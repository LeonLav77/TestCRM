<?php
namespace Database\Seeders;

use RoleSeeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
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
        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role,
            ]);
        }
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'user_id' => Admin::factory()->create()->id,
            'user_type' => 'App\Models\Admin',
            'password' => Hash::make('password'),
        ]);
        
        
    }
}
