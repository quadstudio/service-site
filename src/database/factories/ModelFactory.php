<?php

use Faker\Generator as Faker;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\ProductGroup;
use QuadStudio\Service\Site\Models\ProductGroupType;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\StorehouseProduct;
use QuadStudio\Service\Site\Models\Unsubscribe;
use QuadStudio\Service\Site\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Storehouse::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ru_Ru\Company($faker));
    return [
        'name'     => $faker->company(),
        'url'      => 'http://odinremont.ru/yandex.xml',//$faker->url
        'enabled'  => $enabled = $faker->boolean($chanceOfGettingTrue = 70),
        'everyday' => $enabled ? $faker->boolean($chanceOfGettingTrue = 50) : false,
        'user_id'  => User::query()->whereHas('addresses', function ($address) {
            $address->where('type_id', 6);
        })->get()->random()->id,
    ];
});

$factory->afterCreating(Storehouse::class, function ($storehouse, Faker $faker) {
    Address::query()
        ->where('type_id', 6)
        ->where('addressable_type', 'users')
        ->where('addressable_id', $storehouse->user_id)
        ->where('addressable_id', '!=', 1)
        ->each(function ($address) use ($storehouse) {
            $address
                ->storehouse()
                ->associate($storehouse)
                ->save();
        });
    if ($faker->boolean(70)) {
        $storehouse->products()->createMany(factory(StorehouseProduct::class, $faker->numberBetween(1, 10))->make()->toArray());
        $storehouse->update(['uploaded_at' => $faker->dateTimeBetween($startDate = '-3 weeks')->format('d.m.Y H:i:s')]);
    }

});

$factory->define(StorehouseProduct::class, function (Faker $faker) {

    return [
        'quantity'   => $faker->numberBetween($min = 1, $max = 100),
        'product_id' => function () {
            return Product::query()
                ->where('enabled', 1)
                ->where('active', 1)
                ->where('forsale', 1)
                ->where(config('site.check_field'), 1)
                ->whereNull('equipment_id')
                ->get()->random()->id;
        },
    ];
});

$factory->define(ProductGroup::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ru_Ru\Company($faker));
    return [
        'id'            => $faker->lexify('???????????'),
        'name'          => $faker->sentence(2),
        'type_id' => ProductGroupType::query()->get()->random()->id,
        'created_at'    => now(),
    ];
});
//
$factory->afterCreating(ProductGroup::class, function ($productGroup, Faker $faker) {

    Product::query()->inRandomOrder()->limit(10)->get()->each(function($product) use ($productGroup){
        $product->update(['group_id' => $productGroup->getkey()]);
    });

});

//$factory->afterCreating(ProductGroup::class, function ($productGroup, Faker $faker) {
//
//    StorehouseProduct::query()->inRandomOrder()->limit(5)->get()->each(function($storehouseProduct) use ($productGroup){
//        $storehouseProduct->product->update(['group_id' => $productGroup->getkey()]);
//    });
//
//    Address::query()
//        ->where('type_id', 6)
//        ->where('addressable_type', 'users')
//        ->where('addressable_id', '!=', 1)
//        ->each(function ($address) use ($productGroup) {
//            $address->product_groups()->sync([$productGroup->getKey()]);
//        });
////    if ($faker->boolean(70)) {
////        $storehouse->products()->createMany(factory(StorehouseProduct::class, $faker->numberBetween(1, 10))->make()->toArray());
////        $storehouse->update(['uploaded_at' => $faker->dateTimeBetween($startDate = '-3 weeks')->format('d.m.Y H:i:s')]);
////    }
//
//});

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(Unsubscribe::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
    ];
});
