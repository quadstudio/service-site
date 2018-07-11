<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
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
        Schema::create("{$this->prefix}parts", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('repair_id');
            $table->string('product_id', 11);
            $table->unsignedTinyInteger('count')->default(1);
            $table->decimal('cost')->default(0.00);
            $table->timestamps();
            $table
                ->foreign('repair_id')
                ->references('id')
                ->on("{$this->prefix}repairs")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
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
        Schema::dropIfExists("{$this->prefix}parts");
    }

}
