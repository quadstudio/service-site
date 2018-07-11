<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
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
        Schema::create("{$this->prefix}favorites", function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id', 11);
            $table->unsignedInteger('user_id');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on(config('shop.users', 'users'))
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
        Schema::dropIfExists("{$this->prefix}favorites");
    }

}
