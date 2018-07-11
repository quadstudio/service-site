<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
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
        Schema::create("{$this->prefix}addresses", function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('type_id');
            $table->unsignedInteger('country_id');
            $table->string('region_id', 6);
            $table->string('locality');
            $table->string('street')->nullable(true);
            $table->string('building', 50);
            $table->string('apartment', 50)->nullable(true);
            $table->string('postal', 6)->nullable(true);
            $table->string('name')->nullable(true);
            $table->string('geo', 23)->nullable();
            $table->unsignedInteger('addressable_id')->nullable(true);
            $table->string('addressable_type')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}address_types")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('country_id')
                ->references('id')
                ->on("{$this->prefix}countries")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('region_id')
                ->references('id')
                ->on("{$this->prefix}regions")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}addresses");
    }

}
