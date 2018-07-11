<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineersTable extends Migration
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
        Schema::create("{$this->prefix}engineers", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->unsignedInteger('country_id');
            $table->string('phone', 10);
            $table->string('address');
            $table->timestamps();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('country_id')
                ->references('id')
                ->on("{$this->prefix}countries")
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
        Schema::dropIfExists("{$this->prefix}engineers");
    }

}
