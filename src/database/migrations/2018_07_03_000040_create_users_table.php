<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
        Schema::dropIfExists("{$this->prefix}users");

        Schema::create("{$this->prefix}users", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->boolean('admin')->default(false);
            $table->boolean('display')->default(false);
            $table->string('guid', 36)->nullable(true)->unique(true);
            $table->string('price_type_id', 36)->nullable(true);
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('currency_id');
            $table->string('warehouse_id', 36)->nullable(true);
            $table->string('logo')->nullable(true);
            $table->boolean('verified')->default(false);
            $table->string('verify_token')->nullable(true);
            $table->rememberToken();
            $table->timestamp('logged_at')->nullable();
            $table->timestamps();
            $table
                ->foreign('price_type_id')
                ->references('id')
                ->on("{$this->prefix}price_types")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}contragent_types")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('currency_id')
                ->references('id')
                ->on("{$this->prefix}currencies")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('warehouse_id')
                ->references('id')
                ->on("{$this->prefix}warehouses")
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
        Schema::dropIfExists("{$this->prefix}users");
    }

}
