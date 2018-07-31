<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasheetProductTable extends Migration
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
        Schema::create( $this->prefix.'datasheet_product', function (Blueprint $table) {
            $table->unsignedInteger('datasheet_id');
            $table->string('product_id', 11);
            $table->timestamps();

            $table
                ->foreign('datasheet_id')
                ->references('id')
                ->on("{$this->prefix}datasheets")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(["datasheet_id", "product_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( $this->prefix.'datasheet_product');
    }
}
