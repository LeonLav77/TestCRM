<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddUserTest extends TestCase
{
    // a test where : student tries to create a teacher and admin = fail
    // a test where : teacher tries to create a student = success
    // a test where : teacher tries to create a admin = fail
    // a test where : admin tries to create a teacher and student = success
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
    public function testStudentCreatingUsers()
    {
        $response = $this->actingAs($this->users['Student'])
            ->post(route('users.store'), [
                'name' => 'Teacher',
                'email' => 'shouldNotWork@gmail.com',
                'password' => 'password',
                'role' => 'Teacher',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'role' => 'You may not create this a user with this role'
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'shouldNotWork@gmail.com',
        ]);
        $response = $this->actingAs($this->users['Student'])
            ->post(route('users.store'), [
                'name' => 'Admin',
                'email' => 'these@gmail0Admin',
                'password' => 'password',
                'role' => 'Admin',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'role' => 'You may not create this a user with this role'
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'shouldNotWork@gmail.com',
        ]);
    }

    public function testTeacherCreatingUsers()
    {
        $response = $this->actingAs($this->users['Teacher'])
            ->post(route('users.store'), [
                'name' => 'Student',
                'email' => 'shouldWork@gmail.com',
                'password' => 'password',
                'role' => 'Student',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'shouldWork@gmail.com',
        ]);
        $response = $this->actingAs($this->users['Teacher'])
            ->post(route('users.store'), [
                'name' => 'Admin',
                'email' => 'shouldNotWork@gmail.com',
                'password' => 'password',
                'role' => 'Admin',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'role' => 'You may not create this a user with this role'
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'shouldNotWork@gmail.com',
        ]);
    }

    public function testAdminCreatingUsers()
    {
        $response = $this->actingAs($this->users['Admin'])
            ->post(route('users.store'), [
                'name' => 'Teacher',
                'email' => 'shouldWork@gmail.com',
                'password' => 'password',
                'role' => 'Teacher',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
                'email' => 'shouldWork@gmail.com',
            ]);

        $response = $this->actingAs($this->users['Admin'])
            ->post(route('users.store'), [
                'name' => 'Student',
                'email' => 'shouldWorkStudent@gmail.com',
                'password' => 'password',
                'role' => 'Student',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
                'email' => 'shouldWorkStudent@gmail.com',
            ]);
        }
    public function testBadData()
    {
        $response = $this->actingAs($this->users['Admin'])
            ->post(route('users.store'), [
                'name' => '',
                'email' => '',
                'password' => '',
                'role' => '',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
            'role' => 'The role field is required.',
        ]);
    }
    public function testBadRole()
    {
        $response = $this->actingAs($this->users['Admin'])
            ->post(route('users.store'), [
                'name' => 'Teacher',
                'email' => 'shouldNotWork@gmail.com',
                'password' => 'password',
                'role' => 'User',
            ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'role' => 'Invalid role'
        ]);
    }
}
