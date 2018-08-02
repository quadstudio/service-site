<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
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
        Schema::create( $this->prefix.'messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('receiver_id');
            $table->text('text');
            $table->boolean('received')->default(false);
            $table->unsignedInteger('message_id')->nullable(true);
            $table->unsignedInteger('messagable_id')->nullable(true);
            $table->string('messagable_type')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table
                ->foreign('receiver_id')
                ->references('id')
                ->on("{$this->prefix}users")
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('message_id')
                ->references('id')
                ->on("{$this->prefix}messages")
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( $this->prefix.'datasheet_product');
    }
}
