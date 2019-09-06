<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorehouseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storehouse_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('storehouse_id');
            $table->text('message');
            $table->text('url');
            $table->enum('type', ['error', 'success']);
            $table->timestamps();

            $table
                ->foreign('storehouse_id')
                ->references('id')
                ->on("storehouses")
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
        Schema::dropIfExists('storehouse_logs');
    }
}
