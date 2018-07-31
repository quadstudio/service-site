<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
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
        Schema::create("{$this->prefix}images", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
            $table->unsignedInteger('size');
            $table->string('mime');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->unsignedInteger('imageable_id')->nullable(true);
            $table->string('imageable_type')->nullable(true);
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
        Schema::dropIfExists("{$this->prefix}images");
    }

}
