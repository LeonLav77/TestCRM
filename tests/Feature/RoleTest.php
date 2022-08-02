<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
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
    private $teacher_test;
    private $student_test;
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
        }
        $this->teacher_test = User::factory()->create([
            'name' => 'Teacher',
            'email' => 'these@gmail0',
            'user_id' => Str::uuid(16),
            'password' => Hash::make('password'),
            'user_type' => 'App\Models\Teacher',
            'user_id' => Teacher::factory()->create()->id,
        ]);
        $this->student_test = User::factory()->create([
            'name' => 'Student',
            'email' => 'these@gmail01',
            'user_id' => Str::uuid(16),
            'password' => Hash::make('password'),
            'user_type' => 'App\Models\Student',
            'user_id' => Student::factory()->create()->id,
        ]);
    }
    public function testRoles(){
        assertTrue($this->teacher_test->hasRole('App\Models\Teacher'));
        assertTrue($this->student_test->hasRole('App\Models\Student'));
        $this->assertTrue(true);
    }
}
