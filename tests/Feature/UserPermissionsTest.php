<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPermissionsTest extends TestCase
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
    
    public function testViewIndex()
    {
        $this->actingAs($this->users['Admin'])->get(Route('users.index'))
            ->assertStatus(200)
            ->assertSee('Users');
    }
    // view the form to create a new user
    public function testViewCreate()
    {
        $this->actingAs($this->users['Admin'])->get(Route('users.create'))
            ->assertStatus(200)
            ->assertSee('Name')
            ->assertSee('Email Address')
            ->assertSee('Role')
            ->assertSee('Password')
            ->assertSee('Password Confirmation')
            ->assertSee('Save');
    }
    // admin can see 3 people in the list
    public function testAdminSeeThreePeople()
    {
        $this->actingAs($this->users['Admin'])->get(Route('users.index'))
            ->assertStatus(200)
            ->assertSee($this->users['Teacher']->name)
            ->assertSee($this->users['Student']->name)
            ->assertSee($this->users['Admin']->name);
    }
    // teacher can see only 2 people in the list
    public function testTeacherSeeTwoPeople()
    {
        $this->actingAs($this->users['Teacher'])->get(Route('users.index'))
            ->assertStatus(200)
            ->assertSee($this->users['Teacher']->name)
            ->assertSee($this->users['Student']->name)
            ->assertDontSee($this->users['Admin']->name);
    }
    // student can see only 1 person in the list
    public function testStudentSeeOnePerson()
    {
        $this->actingAs($this->users['Student'])->get(Route('users.index'))
            ->assertStatus(200)
            ->assertSee($this->users['Student']->name)
            ->assertDontSee($this->users['Teacher']->name)
            ->assertDontSee($this->users['Admin']->name);
    }
}
