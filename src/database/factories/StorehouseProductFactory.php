<?php

use Faker\Generator as Faker;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\StorehouseProduct;

$factory->define(StorehouseProduct::class, function (Faker $faker) {

	return [
		'storehouse_id' => factory(Storehouse::class),
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
