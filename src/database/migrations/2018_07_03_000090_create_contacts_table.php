<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
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
        Schema::create("{$this->prefix}contacts", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(true);
            $table->unsignedInteger('type_id');
            $table->string('name');
            $table->string('web')->nullable(true);
            $table->string('position')->nullable(true);
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
                ->on("{$this->prefix}contact_types")
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
        Schema::dropIfExists("{$this->prefix}contacts");
    }

}
