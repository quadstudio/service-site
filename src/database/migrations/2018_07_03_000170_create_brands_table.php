<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
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
        Schema::create("{$this->prefix}brands", function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name', 191)->unique();
            $table->string('logo');
            $table->string('enabled');
            $table->unsignedInteger('country_id');
            $table->text('description')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists("{$this->prefix}brands");
    }

}
