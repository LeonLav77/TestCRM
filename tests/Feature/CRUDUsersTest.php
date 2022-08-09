<?php

namespace Tests\Feature;

use Route;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;

class CRUDUsersTest extends TestCase
{
    private $users = [];
    public function setUp(): void
    {
        parent::setUp();
        $roles =  [
            'Teacher',
            'Student',
            'Admin'
        ];
        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role,
            ]);
            $model = 'App\\Models\\' . $role;
            $this->users[$role] = User::factory()->create([
                'name' => $role,
                'email' => $role . '@gmail.com',
                'user_id' => Str::uuid(16),
                'password' => Hash::make('password'),
                'user_type' => 'App\\Models\\'.$role,
                'user_id' => $model::factory()->create()->id,
            ]);
        }
    }

    // update a user
    public function testUpdateAsAdmin()
    {
        $response = $this->actingAs($this->users['Admin'])->put(Route('users.update', $this->users['Student']), [
            'name' => 'New Name',
            'email' => 'newStudent@example.com',
            'role' => 'Student',
        ]);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(Route('users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Name',
            'email' => 'newStudent@example.com',
        ]);
    }
    public function testUpdateAsTeacherOrStudent()
    {
        $response = $this->actingAs($this->users['Teacher'])->put(Route('users.update', $this->users['Student']), [
            'name' => 'New New Name',
            'email' => 'newNewStudent@gmail.com',
            'role' => 'Student',
        ]);
        $response->assertStatus(302)
        ->assertSessionHasErrors(['role'=>'You may not edit this user'])
        ->assertRedirect(Route('users.index'));
        $this->assertDatabaseMissing('users', [
            'name' => 'New New Name',
            'email' => 'newNewStudent@gmail.com',
        ]);

        $response = $this->actingAs($this->users['Student'])->put(Route('users.update', $this->users['Teacher']), [
            'name' => 'New New Name',
            'email' => 'newNewStudent@gmail.com',
            'role' => 'Student',
        ]);
        $response->assertStatus(302)
        ->assertSessionHasErrors(['role'=>'You may not edit this user'])
        ->assertRedirect(Route('users.index'));
        $this->assertDatabaseMissing('users', [
            'name' => 'New New Name',
            'email' => 'newNewStudent@gmail.com',
        ]);
    }

    public function testDeleteAsAdmin()
    {
        $response = $this->actingAs($this->users['Admin'])->delete(Route('users.destroy', $this->users['Student']));
        $response->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(Route('users.index'));
        $this->assertDatabaseMissing('users', [
            'name' => 'Student',
            'email' => 'shouldWorkStudent',
        ]);
    }

    public function testDeleteAsTeacherOrStudent()
    {
        $response = $this->actingAs($this->users['Teacher'])->delete(Route('users.destroy', $this->users['Student']));
        $response->assertStatus(302)
        ->assertSessionHasErrors(['role'=>'You may not delete this user'])
        ->assertRedirect(Route('users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Student',
            'email' => 'Student@gmail.com',
        ]);

        $response = $this->actingAs($this->users['Student'])->delete(Route('users.destroy', $this->users['Teacher']));
        $response->assertStatus(302)
        ->assertSessionHasErrors(['role'=>'You may not delete this user'])
        ->assertRedirect(Route('users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Teacher',
            'email' => 'Teacher@gmail.com',
        ]);
    }
}
