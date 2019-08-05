<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorehouseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storehouse_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('storehouse_id');
            $table->string('product_id', 11);
            $table->unsignedMediumInteger('quantity')->default(0);
            $table->timestamps();

            $table
                ->foreign('storehouse_id')
                ->references('id')
                ->on("storehouses")
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on("products")
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
        Schema::dropIfExists('storehouse_products');
    }
}
