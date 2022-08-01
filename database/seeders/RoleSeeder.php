<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::dropIfExists('roles');
	}

	/**
	 * Run the migrations.
	 */
	public function up()
	{
        DB::table('users')->insert([
            'name' => 'Teacher',
        ]);
        DB::table('users')->insert([
            'name' => 'Student',
        ]);
	}
};
