<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
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
        Schema::create("{$this->prefix}phones", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('contact_id')->nullable(true);
            $table->string('number', 10);
            $table->string('extra', 20)->nullable(true);
            $table->timestamps();
            $table
                ->foreign('country_id')
                ->references('id')
                ->on("{$this->prefix}countries")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('contact_id')
                ->references('id')
                ->on("{$this->prefix}contacts")
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
        Schema::dropIfExists("{$this->prefix}phones");
    }

}
