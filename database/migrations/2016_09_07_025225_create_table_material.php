<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaterial extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material_master', function(Blueprint $table)
		{
			$table->string('code',25)->primary();
			$table->string('name',25)->index();
			$table->string('color',11);
			$table->integer('size');
			$table->integer('type');
			$table->string('created_by',25);
			$table->timestamps();
		});

		// DB::unprepared('alter table material_master MODIFY column updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('material_master');
	}

}
