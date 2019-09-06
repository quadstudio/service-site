<?php

use Faker\Generator as Faker;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\User;

$factory->define(Storehouse::class, function (Faker $faker) {
    return [
	    'name'     => $faker->company(),
	    'url'      => 'http://odinremont.ru/yandex.xml',//$faker->url
	    'enabled'  => $enabled = $faker->boolean($chanceOfGettingTrue = 70),
	    'everyday' => $enabled ? $faker->boolean($chanceOfGettingTrue = 50) : false,
	    'user_id'  => factory(User::class),
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
