<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
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
        Schema::create("{$this->prefix}relations", function (Blueprint $table) {
            $table->string('product_id', 11);
            $table->string('relation_id', 11);

            $table
                ->foreign('product_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('relation_id')
                ->references('id')
                ->on("{$this->prefix}products")
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}relations");
    }

}
