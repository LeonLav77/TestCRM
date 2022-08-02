<?php
namespace Database\Seeders;

use RoleSeeder;
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
        $teachers_id = Str::random(16);
        DB::table('roles')->insertGetId([
            'id' => $teachers_id,
            'name' => 'Teacher',
        ]);
        DB::table('roles')->insert([
            'id' => Str::random(16),
            'name' => 'Student',
        ]);
        $user_id = Str::random(16);
        DB::table('teachers')->insert([
            'id' => $user_id,
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin Admin',
            'user_id' => $user_id, // ODGOVARA UUIDU U TEACHERS TABLICI
            'user_type' => 'App\Models\Teacher',
            'email' => 'leonlav77@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
