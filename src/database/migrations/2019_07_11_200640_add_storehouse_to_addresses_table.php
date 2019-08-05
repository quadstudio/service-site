<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStorehouseToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('addresses')) {
            if (!Schema::hasColumn('addresses', 'storehouse_id')) {
                Schema::table('addresses', function (Blueprint $table) {
                    $table->unsignedInteger('storehouse_id')->nullable();

                    $table
                        ->foreign('storehouse_id')
                        ->references('id')
                        ->on("storehouses")
                        ->onUpdate('cascade')
                        ->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('addresses')) {
            if (Schema::hasColumn('addresses', 'storehouse_id')) {
                Schema::table('addresses', function (Blueprint $table) {
                    $table->dropForeign(['storehouse_id']);
                    $table->dropColumn('storehouse_id');
                });
            }
        }
    }
}
