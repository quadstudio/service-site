<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
        Schema::create("{$this->prefix}orders", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(true);
            $table->unsignedInteger('status_id');
            $table->text('comment')->nullable(true);
            $table->timestamps();


            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('set null');
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
        Schema::dropIfExists("{$this->prefix}orders");
    }

}
