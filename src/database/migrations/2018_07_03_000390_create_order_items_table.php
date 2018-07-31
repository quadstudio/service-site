<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{

    private $prefix;

    public function __construct()
    {
        $this->prefix = env('DB_PREFIX', '');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("{$this->prefix}order_items", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->string('product_id', 11);
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price');
            $table->unsignedInteger('currency_id');
            $table->string('sku')->nullable();
            $table->decimal('weight', 8, 3)->nullable();
            $table->boolean('availability')->nullable();
            $table->boolean('service')->default(0);
            $table->string('brand_id', 36)->nullable(true);
            $table->string('unit', 10)->nullable();
            $table->timestamps();

            $table
                ->foreign('order_id')
                ->references('id')
                ->on("{$this->prefix}orders")
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('brand_id')
                ->references('id')
                ->on("{$this->prefix}brands")
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('currency_id')
                ->references('id')
                ->on("{$this->prefix}currencies")
                ->onUpdate('restrict')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}order_items");
    }

}
