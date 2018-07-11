<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
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
        Schema::create("{$this->prefix}countries", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alpha2', 2)->unique();
            $table->string('phone', 4)->nullable();
            $table->string('prefix', 10)->nullable();
            $table->string('flag')->nullable(true);
            $table->boolean('enabled')->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}countries");
    }

}
