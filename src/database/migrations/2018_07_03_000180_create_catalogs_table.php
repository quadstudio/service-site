<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsTable extends Migration
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
        Schema::create("{$this->prefix}catalogs", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_plural');
            $table->unsignedInteger('catalog_id')->nullable(true);
            $table->text('description')->nullable(true);
            $table->boolean('enabled')->default(1);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table
                ->foreign('catalog_id')
                ->references('id')
                ->on("{$this->prefix}catalogs")
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}catalogs");
    }

}
