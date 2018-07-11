<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
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
        Schema::create("{$this->prefix}files", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('repair_id')->nullable(true);
            $table->unsignedInteger('type_id');
            $table->string('name');
            $table->string('path');
            $table->unsignedInteger('size');
            $table->string('mime');
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('repair_id')
                ->references('id')
                ->on("{$this->prefix}repairs")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}file_types")
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
        Schema::dropIfExists("{$this->prefix}files");
    }

}
