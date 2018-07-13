<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
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
        Schema::create("{$this->prefix}costs", function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('cost_work');
            $table->decimal('cost_road');
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('equipment_id');
            $table->timestamps();

            $table
                ->foreign('currency_id')
                ->references('id')
                ->on("{$this->prefix}currencies")
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::dropIfExists("{$this->prefix}costs");
    }

}
