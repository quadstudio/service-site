<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
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
        Schema::create($this->prefix.'schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger('action_id');
            $table->string('url');
            $table->timestamps();
            $table
                ->foreign('action_id')
                ->references('id')
                ->on("{$this->prefix}schedule_actions")
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
        Schema::dropIfExists($this->prefix.'schedules');
    }
}
