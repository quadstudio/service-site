<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasheetsTable extends Migration
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
        Schema::create( $this->prefix.'datasheets', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_from')->nullable(true);
            $table->date('date_to')->nullable(true);
            $table->text('tags')->nullable(true);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('file_id');

            $table->timestamps();

            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}datasheet_types")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('file_id')
                ->references('id')
                ->on("{$this->prefix}files")
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
        Schema::dropIfExists( $this->prefix.'datasheets');
    }
}
