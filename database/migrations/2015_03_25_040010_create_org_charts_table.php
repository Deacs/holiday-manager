<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgChartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('org_charts', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('department_id')->foreign('department_id')->references('id')->on('departments');
			$table->string('path');
			$table->string('thumbnail_path');
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
		Schema::drop('org_charts');
	}

}
