<?php
namespace Database\Seeders;

use RoleSeeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles =  [
            'Teacher',
            'Student',
            'Admin'
        ];
        $role_ids = [];
        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role,
            ]);
            $role_ids[$role] = Role::where('name', $role)->first()->id;
        }
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'user_id' => Admin::factory()->create()->id,
            'user_type' => 'App\Models\Admin',
            'password' => Hash::make('password'),
            'role_id' => $role_ids['Admin'],
        ]);
        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@test.com',
            'user_id' => Teacher::factory()->create()->id,
            'user_type' => 'App\Models\Teacher',
            'password' => Hash::make('password'),
            'role_id' => $role_ids['Teacher'],
        ]);
        User::create([
            'name' => 'Student',
            'email' => 'student@test.com',
            'user_id' => Student::factory()->create()->id,
            'user_type' => 'App\Models\Student',
            'password' => Hash::make('password'),
            'role_id' => $role_ids['Student'],
        ]);
    }
}
