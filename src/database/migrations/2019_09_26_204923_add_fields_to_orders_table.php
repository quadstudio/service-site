<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function (Blueprint $table) {
			$table->unsignedTinyInteger('in_stock_type')->default(0);
			$table->decimal('percent_compl', 8, 2)->default(0.00);
			$table->unsignedInteger('brother_id')->nullable();

			$table->foreign('brother_id')
				->references('id')
				->on("orders")
				->onUpdate('cascade')
				->onDelete('set null');;

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('in_stock_type');
			$table->dropColumn('percent_compl');
			$table->dropForeign(['brother_id']);
			$table->dropColumn('brother_id');
		});

	}
}
