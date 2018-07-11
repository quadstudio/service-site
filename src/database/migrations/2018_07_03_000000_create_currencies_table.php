<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
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
        Schema::create("{$this->prefix}currencies", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 3)->unique();
            $table->string('title', 50);
            $table->decimal('rates', 8, 6)->default(1.000000);
            $table->unsignedTinyInteger('multiplicity')->default(1);
            $table->string('symbol_left')->nullable();
            $table->string('symbol_right')->nullable();
            $table->boolean('fix_rate')->default(1);
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
        Schema::dropIfExists("{$this->prefix}currencies");
    }

}
