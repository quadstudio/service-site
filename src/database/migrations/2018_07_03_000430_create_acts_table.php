<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActsTable extends Migration
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
        Schema::create("{$this->prefix}acts", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            $table->tinyInteger('number');
            $table->string('client_name');
            $table->string('client_address');
            $table->string('client_inn', 12);
            $table->string('client_kpp', 9)->nullable(true);
            $table->string('client_okpo', 10)->nullable(true);
            $table->string('client_rs', 20);
            $table->string('client_ks', 20);
            $table->string('client_bik', 11);
            $table->string('client_bank');
            $table->string('contract_number', 50);
            $table->date('contract_date');
            $table->tinyInteger('nds');
            $table->boolean('nds_enabled')->default(false);
            $table->boolean('opened')->default(false);
            $table->string('our_name');
            $table->string('our_address');
            $table->string('our_inn', 12);
            $table->string('our_kpp', 9);
            //$table->string('our_okpo', 10);
            $table->string('our_rs', 20);
            $table->string('our_ks', 20);
            $table->string('our_bik', 11);
            $table->string('our_bank');

            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
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
        Schema::dropIfExists("{$this->prefix}acts");
    }

}
