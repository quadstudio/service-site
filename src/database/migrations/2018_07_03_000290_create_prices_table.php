<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
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
        Schema::create("{$this->prefix}prices", function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id', 11);
            $table->unsignedInteger('currency_id');
            $table->string('type_id', 36);
            $table->decimal('price');
            $table->timestamps();


            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('currency_id')
                ->references('id')
                ->on("{$this->prefix}currencies")
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}price_types")
                ->onUpdate('cascade')
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
        Schema::dropIfExists("{$this->prefix}prices");
    }

}
