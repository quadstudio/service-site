<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStoriesTable extends Migration
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
        Schema::create("{$this->prefix}order_stories", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('status_id');
            $table->timestamps();

            $table
                ->foreign('order_id')
                ->references('id')
                ->on("{$this->prefix}orders")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('status_id')
                ->references('id')
                ->on("{$this->prefix}order_statuses")
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
        Schema::dropIfExists("{$this->prefix}order_stories");
    }

}
