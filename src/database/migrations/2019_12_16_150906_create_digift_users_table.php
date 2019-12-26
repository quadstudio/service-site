<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigiftUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('digift_users', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->unsignedInteger('user_id');
			$table->string('accessToken');
			$table->string('tokenExpired');
			$table->string('fullUrlToRedirect');
			$table->timestamp('checked_at')->nullable();
			$table->timestamps();

			$table
				->foreign('user_id')
				->references('id')
				->on("users")
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
		Schema::dropIfExists('digift_users');
	}
}
