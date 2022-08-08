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
use function PHPUnit\Framework\assertTrue;

class RoleTest extends TestCase
{
    // have 2 user, 1 with each role
    // test if user can access certain routes
    // test if user can access certain routes with correct role
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
    public function testRoles(){
        assertTrue($this->users['Teacher']->hasRole('App\Models\Teacher'));
        assertTrue($this->users['Student']->hasRole('App\Models\Student'));
        assertTrue($this->users['Admin']->hasRole('App\Models\Admin'));
    }
    public function testTeacherMiddleware(){
        $this->actingAs($this->users['Teacher'])
            ->get('/teacher/test')
            ->assertStatus(200);
        $this->actingAs($this->users['Teacher'])
            ->get('/student/test')
            ->assertStatus(401);
        $this->actingAs($this->users['Teacher'])
            ->get('/admin/test')
            ->assertStatus(401);
    }
    public function testStudentMiddleware(){
        $this->actingAs($this->users['Student'])
            ->get('/teacher/test')
            ->assertStatus(401);
        $this->actingAs($this->users['Student'])
            ->get('/student/test')
            ->assertStatus(200);
        $this->actingAs($this->users['Student'])
            ->get('/admin/test')
            ->assertStatus(401);
    }
    public function testAdminMiddleware(){
        $this->actingAs($this->users['Admin'])
            ->get('/teacher/test')
            ->assertStatus(401);
        $this->actingAs($this->users['Admin'])
            ->get('/student/test')
            ->assertStatus(401);
        $this->actingAs($this->users['Admin'])
            ->get('/admin/test')
            ->assertStatus(200);
    }
}
