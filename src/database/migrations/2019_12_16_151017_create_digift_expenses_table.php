<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigiftExpensesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('digift_expenses', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->uuid('user_id');
			$table->unsignedBigInteger('operationValue');
			$table->timestamps();

			$table
				->foreign('user_id')
				->references('id')
				->on("digift_users")
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('digift_expenses');
	}
}
