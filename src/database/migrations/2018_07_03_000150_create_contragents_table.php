<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentsTable extends Migration
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
        Schema::create("{$this->prefix}contragents", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(true);
            $table->unsignedInteger('type_id');
            $table->string('name');
            $table->string('guid', 36)->nullable(true)->unique(true);
            $table->string('inn', 12)->unique();
            $table->string('ogrn', 15);
            $table->string('okpo', 10);
            $table->string('kpp', 9)->nullable(true);
            $table->string('rs', 20);
            $table->string('bik', 11);
            $table->string('bank');
            $table->string('ks', 20)->nullable();
            $table->boolean('nds')->default(1);
            $table->unsignedInteger('organization_id')->nullable(true);
            $table->unsignedInteger('currency_id')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}contragent_types")
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
        Schema::dropIfExists("{$this->prefix}contragents");
    }

}
