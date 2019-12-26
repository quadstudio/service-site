<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'namespace' => 'Api',
],
	function () {

		// Получить списание бонуса из Дигифт
		Route::post('/digift', 'DigiftController@storeExpense');

		// Отправить все бонусы автоматически в Дигифт
		Route::get('/digift/changeBalance', 'DigiftController@changeBalance')
			->name('api.digift.changeBalance');

		// Сверить баланс всех пользователей Дигифт
		Route::get('/digift/profile', 'DigiftController@profile')
			->name('api.digift.profile');

	});


