<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairFailsTable extends Migration
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
        Schema::create("{$this->prefix}repair_fails", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('repair_id');
            $table->string('field', 50);
            $table->string('comment')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('repair_id')
                ->references('id')
                ->on("{$this->prefix}repairs")
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
        Schema::dropIfExists("{$this->prefix}repair_fails");
    }

}
