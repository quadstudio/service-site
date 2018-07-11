<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalogsTable extends Migration
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
        Schema::create("{$this->prefix}analogs", function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id', 11);
            $table->string('analog_id', 11);
            $table->unsignedSmallInteger('ratio')->default(1);

            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('analog_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}analogs");
    }

}
