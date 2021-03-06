<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('stock_master', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamp('date');
			$table->string('no')->index();
			$table->timestamp('date_bc');
			$table->string('no_bc');
			$table->integer('type_bc');
			$table->string('code_mat');
			$table->string('code_company');
			$table->integer('qty');
			$table->integer('unit');
			$table->integer('price');
			$table->integer('curr');
			$table->string('no_inv');
			$table->string('no_po');
			$table->string('no_so');
			$table->integer('to');
			$table->integer('type');
			$table->string('created_by',25);
			$table->timestamps();
		});

		// DB::unprepared('alter table material MODIFY column created_at timestamp NOT NULL');

		// DB::unprepared('alter table stock_master MODIFY column updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('stock_master');
	}

}
