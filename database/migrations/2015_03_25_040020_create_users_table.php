<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug');
            $table->string('email')->unique();
			$table->string('password');
            $table->string('telephone')->nullable();
			$table->integer('department_id')->foreign('department_id')->references('id')->on('departments');
			$table->integer('location_id')->foreign('location_id')->references('id')->on('locations');
            $table->boolean('super_user')->default(0);
			$table->integer('annual_holiday_allowance')->default(25);
			$table->index('department_id');
			$table->index('location_id');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
