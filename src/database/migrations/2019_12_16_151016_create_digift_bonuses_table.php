<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigiftBonusesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('digift_bonuses', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->uuid('user_id');
			$table->unsignedInteger('bonusable_id');
			$table->string('bonusable_type');
			$table->unsignedBigInteger('operationValue');
			$table->boolean('blocked')->default(0);
			$table->boolean('sended')->default(0);
			$table->string('digift_resp')->nullable();
			$table->timestamp('checked_at')->nullable();
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
		Schema::dropIfExists('digift_bonuses');
	}
}
