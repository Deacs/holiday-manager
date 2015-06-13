<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('holiday_requests', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->references('id')->on('users');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status_id')->references('id')->on('status')->default(1);
            $table->integer('approved_by')->nullable()->references('id')->on('users');
            $table->integer('declined_by')->nullable()->references('id')->on('users');
			$table->index('user_id');
			$table->index('status_id');
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
		Schema::drop('holiday_requests');
	}

}
