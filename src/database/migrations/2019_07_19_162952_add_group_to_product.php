<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddGroupToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'group_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('group_id', 11)->nullable();
                $table
                    ->foreign('group_id')
                    ->references('id')
                    ->on("product_groups")
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            });
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'group_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            });
        }
    }
}
