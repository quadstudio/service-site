<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
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
        Schema::create("{$this->prefix}equipments", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable(true);
            $table->boolean('enabled')->default(1);
            $table->unsignedInteger('catalog_id');
            $table->timestamps();

            $table
                ->foreign('catalog_id')
                ->references('id')
                ->on("{$this->prefix}catalogs")
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
        Schema::dropIfExists("{$this->prefix}equipments");
    }

}
