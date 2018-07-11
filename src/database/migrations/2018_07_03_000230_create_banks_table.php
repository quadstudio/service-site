<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
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
        Schema::create("{$this->prefix}banks", function (Blueprint $table) {
            $table->string('id', 11)->primary();
            $table->string('ks', 20)->nullable();
            $table->string('bank');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phones')->nullable();
            $table->string('inn', 12)->nullable();
            $table->boolean('disabled')->default(0);
            $table->date('date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}banks");
    }

}
