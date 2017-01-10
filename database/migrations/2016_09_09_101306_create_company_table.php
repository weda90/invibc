<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_master', function(Blueprint $table)
		{
			$table->string('code',25)->primary();
			$table->string('name',25)->index();
			$table->integer('type');
			$table->text('address');
			$table->string('npwp')->index();
			$table->string('status');
			$table->string('location');
			$table->string('created_by',25);
			$table->timestamps();
		});


		// DB::unprepared('alter table company_master MODIFY column updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('company_master');
	}

}
