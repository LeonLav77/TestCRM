<?php
namespace Database\Seeders;

use RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        DB::table('users')->insert([
            'name' => 'Teacher',
        ]);
        DB::table('users')->insert([
            'name' => 'Student',
        ]);
    }
}
