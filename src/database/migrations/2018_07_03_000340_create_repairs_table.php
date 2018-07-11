<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
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
        Schema::create("{$this->prefix}repairs", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('status_id')->default(1);
            $table->unsignedInteger('user_id');
            $table->string('serial', 32);
            $table->string('number', 10);
            $table->decimal('cost_work')->default(0.00);
            $table->decimal('cost_road')->default(0.00);
            $table->boolean('allow_work');
            $table->boolean('allow_road');
            $table->boolean('allow_parts');
            $table->string('warranty_number', 10);
            $table->unsignedTinyInteger('warranty_period');
            $table->date('date_launch');
            $table->date('date_trade');
            $table->date('date_call');
            $table->date('date_repair');
            $table->unsignedInteger('engineer_id');
            $table->unsignedInteger('trade_id');
            $table->unsignedInteger('launch_id');
            $table->text('reason_call');
            $table->text('diagnostics');
            $table->text('works');
            $table->text('recommends')->nullable(true);
            $table->text('comment')->nullable(true);
            //
            $table->unsignedInteger('country_id');
            $table->string('client');
            $table->string('phone_primary', 10);
            $table->string('phone_secondary', 10);
            $table->string('address');
            $table->timestamps();

            $table
                ->foreign('status_id')
                ->references('id')
                ->on("{$this->prefix}repair_statuses")
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('restrict');


            $table
                ->foreign('engineer_id')
                ->references('id')
                ->on("{$this->prefix}engineers")
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table
                ->foreign('trade_id')
                ->references('id')
                ->on("{$this->prefix}trades")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('launch_id')
                ->references('id')
                ->on("{$this->prefix}launches")
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
        Schema::dropIfExists("{$this->prefix}repairs");
    }

}
