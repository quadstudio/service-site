<?php

namespace QuadStudio\Service\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSiteSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('product_groups')->truncate();
        DB::table('product_group_types')->truncate();

        DB::table('product_group_types')->insert(trans('site::product_group_type.seed'));
        DB::table('product_groups')->insert(trans('site::product_group.seed'));
        DB::table('products')->where('id', 'УТ-00000104')->update(['group_id' => '00000000001']);
        DB::table('products')->where('id', 'УТ-00000106')->update(['group_id' => '00000000002']);
        DB::table('products')->where('id', 'УТ-00000107')->update(['group_id' => '00000000003']);
        DB::table('products')->where('id', 'УТ-00000109')->update(['group_id' => '00000000004']);
        DB::table('products')->where('id', 'УТ-00000112')->update(['group_id' => '00000000005']);
        DB::table('products')->where('id', 'УТ-00000113')->update(['group_id' => '00000000006']);

        //Storehouse::query()->truncate();
        //Storehouse::flushEventListeners();
        //DB::table('storehouse_products')->truncate();
        //factory(Storehouse::class, 15)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
