<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyRatesTable extends Migration
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
        Schema::create("{$this->prefix}currency_rates", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id');
            $table->date('date');
            $table->decimal('rates', 8, 6);
            $table->unsignedTinyInteger('multiplicity');
            $table->timestamps();

            $table
                ->foreign('currency_id')
                ->references('id')
                ->on("{$this->prefix}currencies")
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->unique(['currency_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}currency_rates");
    }

}
