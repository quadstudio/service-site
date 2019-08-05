<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressProductGroupTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_product_group_type', function (Blueprint $table) {
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('type_id');

            $table
                ->foreign('address_id')
                ->references('id')
                ->on("addresses")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('type_id')
                ->references('id')
                ->on("product_group_types")
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(["address_id", "type_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_product_group_type');
    }
}
