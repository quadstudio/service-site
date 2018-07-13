<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialsTable extends Migration
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
        Schema::create("{$this->prefix}serials", function (Blueprint $table) {
            $table->string('id', 20)->primary(true);
            $table->unsignedInteger('equipment_id');
            $table->timestamps();
            $table
                ->foreign('equipment_id')
                ->references('id')
                ->on("{$this->prefix}equipments")
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
        Schema::dropIfExists("{$this->prefix}serials");
    }

}
