<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use QuadStudio\Service\Site\Exports\Excel\OrderExcel;
use QuadStudio\Service\Site\Exports\Word\ContractWordProcessor;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Models\Block;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Models\Contract;
use QuadStudio\Service\Site\Models\Element;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Pdf\ActPdf;
use QuadStudio\Service\Site\Pdf\MountingPdf;
use QuadStudio\Service\Site\Pdf\RepairPdf;

Route::group([
	'namespace' => 'Auth',
],
	function () {
		// Authentication Routes...
		Route::get('login', 'LoginController@showLoginForm')->name('login');
		Route::post('login', 'LoginController@login');
		Route::post('logout', 'LoginController@logout')->name('logout');

		// Registration Routes...
		Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
		Route::get('register/fl', 'RegisterController@showRegistrationFlForm')->name('register_fl');
		Route::post('register/fl', 'RegisterController@register_fl');
		Route::post('register', 'RegisterController@register');
		Route::get('/register/confirm/{token}', 'RegisterController@confirm')->name('confirm');


		// Password Reset Routes...
		Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
		Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
		Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
		Route::post('password/reset', 'ResetPasswordController@reset');
	});

Route::group(['middleware' => ['online']],
	function () {

		// Главная страница
		Route::get('/',
			'IndexController@index')
			->name('index');

		// Интернет-магазины
		Route::match(['get', 'post'], '/eshop',
			'MapController@online_stores')
			->name('online-stores');

		// Где купить
		Route::match(['get', 'post'], '/dealers',
			'MapController@where_to_buy')
			->name('where-to-buy');

		// Сервисные центры
		Route::match(['get', 'post'], '/services',
			'MapController@service_centers')
			->name('service-centers');

		// Заявки на монтаж
		Route::match(['get', 'post'], '/mounter-requests',
			'MapController@mounter_requests')
			->name('mounter-requests');
		Route::get('/mounters/create/{address}',
			'MounterController@create')
			->name('mounters.create');
		Route::post('/mounters/{address}',
			'MounterController@store')
			->name('mounters.store');
		Route::resource('/mounters',
			'MounterController')
			->only(['index', 'show', 'edit', 'update']);

		// Файлы
		Route::resource('/files',
			'FileController')
			->only(['index', 'store', 'show', 'destroy']);

		// Каталог
		Route::resource('/catalogs',
			'CatalogController')
			->only(['index', 'show']);
		Route::get('/catalogs/{catalog}/list',
			'CatalogController@list')
			->name('catalogs.list');

		// Оборудование
		Route::resource('/equipments',
			'EquipmentController')
			->only(['index', 'show']);

		// Техдокументация
		Route::resource('/datasheets',
			'DatasheetController')
			->only(['index', 'show']);

		// Витрина товаров
		Route::get('/products/list',
			'ProductController@list')
			->name('products.list');
		Route::resource('/products',
			'ProductController')
			->only(['index', 'show']);
		Route::get('/products/{product}/schemes/{scheme}',
			'ProductController@scheme')
			->name('products.scheme');

		// Новости
		Route::resource('/announcements',
			'AnnouncementController')
			->only(['index']);

		// Обновление курсов валют
		Route::get('/currencies/refresh/',
			'CurrencyController@refresh')
			->name('currencies.refresh');

		// Static pages
		Route::get('/feedback',
			'StaticPageController@feedback')
			->name('feedback');
		Route::post('/feedback',
			'StaticPageController@message')
			->name('message');


		/* Мероприятия */
		Route::resource('/events',
			'EventController')
			->only(['show', 'index']);

		/* Типы мероприятий */
		Route::resource('/event-types',
			'EventTypeController')
			->only(['show'])
			->names([
				'show' => 'event_types.show',
			]);

		/* Заявки */
		Route::get('/members/confirm/{token}',
			'MemberController@confirm')
			->name('members.confirm');
		Route::resource('/members',
			'MemberController')
			->only(['index', 'store']);
		Route::get('/members/register/{event}',
			'MemberController@register')
			->name('members.register');
		Route::get('/members/create/{event_type}',
			'MemberController@create')
			->name('members.create');

		/* Участники */
		Route::resource('/participants',
			'ParticipantController')
			->only(['create']);

		/* Отписаться от рассылки */
		Route::get('/unsubscribe/{email}',
			'UnsubscribeController@showUnsubscribeForm')
			->name('unsubscribe')
			->middleware('signed');
		Route::post('/unsubscribe/{email}',
			'UnsubscribeController@unsubscribe')
			->name('unsubscribe')
			->middleware('signed');

		Route::group(['middleware' => ['auth']],
			function () {
				// Личный кабинет
				Route::get('/home',
					'HomeController@index')
					->name('home');
				Route::post('/home/logo',
					'HomeController@logo')
					->name('home.logo');
				Route::get('/users/{user}/force',
					'HomeController@force')
					->name('users.admin');

				/*
				|--------------------------------------------------------------------------
				|                   БОНУСЫ ДИГИФТ
				|--------------------------------------------------------------------------
				*/
				// Получить бонусы (вознаграждение) Дигифт
				Route::post('/digift/users/{digiftUser}/fullUrlToRedirect',
					'DigiftUserController@fullUrlToRedirect')
					->name('digift.users.fullUrlToRedirect');


				//-------------------------------------------------------------------------
				// Авторизации
				Route::resource('/authorizations',
					'AuthorizationController')
					->middleware('permission:authorizations')
					->only(['index', 'store', 'show']);
				Route::post('/authorizations/{authorization}/message',
					'AuthorizationController@message')
					->middleware('permission:messages')
					->name('authorizations.message');
				Route::get('/authorizations/create/{role}',
					'AuthorizationController@create')
					->name('authorizations.create')
					->middleware('permission:authorizations');

				// Адреса
				Route::resource('/addresses',
					'AddressController')
					->middleware('permission:addresses')
					->except(['create']);
				Route::get('/addresses/create/{address_type}',
					'AddressController@create')
					->middleware('permission:addresses')
					->name('addresses.create');

				// Телефоны адреса
				Route::resource('/addresses/{address}/phones',
					'AddressPhoneController')
					->middleware('permission:addresses')
					->except(['index'])
					->names([
						'create' => 'addresses.phones.create',
						'store' => 'addresses.phones.store',
						'edit' => 'addresses.phones.edit',
						'update' => 'addresses.phones.update',
						'destroy' => 'addresses.phones.destroy',
					]);

				// Инженеры
				Route::resource('/engineers',
					'EngineerController')
					->middleware('permission:engineers')
					->except(['show']);

				// Отчеты по монтажу
				Route::resource('/mountings',
					'MountingController')
					->middleware('permission:mountings')
					->only(['index', 'create', 'store', 'show']);
				Route::post('/mountings/{mounting}/message',
					'MountingController@message')
					->middleware('permission:messages')
					->name('mountings.message');
				Route::get('/mountings/{mounting}/pdf', function (Mounting $mounting) {
					return (new MountingPdf())->setModel($mounting)->render();
				})->middleware('can:pdf,mounting')
					->name('mountings.pdf');

				// Торговые организации
				Route::resource('/trades',
					'TradeController')
					->middleware('permission:trades')
					->except(['show']);

				// Сообщения
				Route::resource('/messages',
					'MessageController')
					->middleware('permission:messages')
					->only(['index', 'show']);

				// Отчеты по ремонту
				Route::resource('/repairs',
					'RepairController')
					->middleware('permission:repairs');
				Route::post('/repairs/{repair}/message',
					'RepairController@message')
					->middleware('permission:messages')
					->name('repairs.message');
				Route::get('/repairs/{repair}/pdf', function (Repair $repair) {
					return (new RepairPdf())->setModel($repair)->render();
				})->middleware('can:pdf,repair')->name('repairs.pdf');

				// Контрагенты
				Route::resource('/contragents',
					'ContragentController')
					->middleware('permission:contragents');
				Route::resource('/contragents/{contragent}/addresses',
					'ContragentAddressController')
					->middleware('permission:addresses')
					->only(['edit', 'update'])
					->names([
						'edit' => 'contragents.addresses.edit',
						'update' => 'contragents.addresses.update',
					]);

				// Контакты
				Route::resource('/contacts',
					'ContactController')
					->middleware('permission:contacts');

				// Телефоны контакта
				Route::resource('/contacts/{contact}/phones',
					'ContactPhoneController')
					->middleware('permission:phones')
					->except(['index'])
					->names([
						'create' => 'contacts.phones.create',
						'store' => 'contacts.phones.store',
						'edit' => 'contacts.phones.edit',
						'update' => 'contacts.phones.update',
						'destroy' => 'contacts.phones.destroy',
					]);

				// Входящие заказы
				Route::group(['middleware' => ['permission:distributors']],
					function () {
						Route::get('/distributors',
							'DistributorController@index')
							->name('distributors.index');
						Route::get('/distributors/{order}',
							'DistributorController@show')
							->name('distributors.show');
						Route::patch('/distributors/{order}',
							'DistributorController@update')
							->name('distributors.update');
						Route::post('/distributors/{order}/message',
							'DistributorController@message')
							->name('distributors.message');
						Route::get('/distributors/{order}/excel', function (Order $order) {
							(new OrderExcel())->setModel($order)->render();
						})->name('distributors.excel')->middleware('can:distributor,order');
						Route::post('/distributors/{order}/payment',
							'DistributorController@payment')
							->name('distributors.payment');
					});


				// Заказы
				Route::post('/orders/load',
					'OrderController@load')
					->middleware('permission:orders')
					->name('orders.load');
				Route::resource('/orders',
					'OrderController')
					->except(['edit'])
					->middleware('permission:orders');
				Route::post('/orders/{order}/message',
					'OrderController@message')
					->middleware('permission:messages')
					->name('orders.message');


				// Акты
				Route::resource('/acts',
					'ActController')
					->middleware('permission:acts')
					->except(['destroy']);
				Route::get('/acts/{act}/pdf', function (Act $act) {
					return (new ActPdf())->setModel($act)->render();
				})
					->middleware('can:pdf,act')
					->name('acts.pdf');

				// Корзина
				Route::get('/cart',
					'CartController@index')
					->name('cart');
				Route::post('/cart/{product}/add',
					'CartController@add')
					->name('buy');
				Route::delete('/cart/remove',
					'CartController@remove')
					->name('removeCartItem');
				Route::put('/cart/update',
					'CartController@update')
					->name('updateCart');
				Route::get('/cart/clear',
					'CartController@clear')
					->name('clearCart');

				Route::resource('/order-items',
					'OrderItemController')
					->only(['destroy']);

				// Контакты
				Route::group(['middleware' => ['permission:contracts']],
					function () {
						Route::resource('/contracts',
							'ContractController')
							->except(['create']);

						Route::get('/contracts/create/{contract_type}',
							'ContractController@create')
							->name('contracts.create');

						Route::get('/contracts/{contract}/download', function (Contract $contract) {
							(new ContractWordProcessor($contract))->render();
						})->name('contracts.download')
							->middleware('can:view,contract');
					});

				// Оптовые склады

				Route::get('/storehouses/excel',
					'StorehouseController@excel')
					->name('storehouses.excel');

				Route::group(['middleware' => ['permission:storehouses']],
					function () {

						Route::resource('/storehouses',
							'StorehouseController');

						Route::post('/storehouses/{storehouse}/excel',
							'StorehouseExcelController@store')
							->name('storehouses.excel.store');


						Route::post('/storehouses/{storehouse}/url',
							'StorehouseUrlController@store')
							->name('storehouses.url.store');
						Route::post('/storehouses/{storehouse}/load',
							'StorehouseUrlController@load')
							->name('storehouses.url.load');

						// Лог ошибок оптового склада
						Route::resource('/storehouses/{storehouse}/logs',
							'StorehouseLogController')
							->only(['index'])
							->names([
								'index' => 'storehouses.logs.index',
							]);
					});

				Route::get('/test', function () {

					$reader = new \XMLReader();
					$reader->open('https://odinremont.ru/yml.xml');
					$doc = new \DOMDocument;
					//$reader->setParserProperty(\XMLReader::VALIDATE, true);

					//dd($reader->isValid());
					$a = 'yml.shop.offers.offer:*';
					$a = [
						'yml' => [
							'shop' => [
								'offers' => [
									'offer' => [
										':id' => [
											'vendorCode',
											'quantity',
										],
									],
								],
							],
						],
					];
					$a = [];
					while ($reader->read()) {
						if ($reader->nodeType == XMLReader::ELEMENT) {
							if ($reader->localName == 'offer') {
								dump($reader->getAttribute('id'));
								$reader->read();
								while ($reader->localName != 'offer') {
									if ($reader->nodeType == XMLReader::ELEMENT and $reader->localName == 'vendorCode') {
										$reader->read();
										if ($reader->nodeType == XMLReader::TEXT) {
											print $reader->value . "\n";
										}
									}
									if ($reader->nodeType == XMLReader::ELEMENT and $reader->localName == 'quantity') {
										$reader->read();
										if ($reader->nodeType == XMLReader::TEXT) {
											print $reader->value . "\n";
										}
									}
									$reader->read();
								}
							}
						}
					}

					dd($a);
				});

				/*
				|--------------------------------------------------------------------------
				|                               АДМИНКА
				|--------------------------------------------------------------------------
				*/

				Route::middleware('admin')
					->namespace('Admin')
					->prefix('admin')
					->group(function () {

						// Панель управления
						Route::get('/',
							'IndexController@index')
						->name('admin');

						Route::name('admin.')->group(function (){

							// Авторизации
							Route::resource('/authorization-brands',
								'AuthorizationBrandController')
								->except(['delete']);
							Route::resource('/authorization-roles',
								'AuthorizationRoleController')
								->except(['delete', 'show', 'create']);
							Route::get('/authorization-roles/create/{role}',
								'AuthorizationRoleController@create')
								->name('authorization-roles.create');
							Route::resource('/authorization-types',
								'AuthorizationTypeController')
								->except(['delete']);
							Route::resource('/authorizations',
								'AuthorizationController')
								->except(['delete']);
							Route::resource('/mounters',
								'MounterController')
								->except(['delete']);
							Route::post('/authorizations/{authorization}/message',
								'AuthorizationController@message')
								->name('authorizations.message');

							// Роуты
							Route::get('routes',
								'RouteController@index')
								->name('routes.index');

							// Отчеты по монтажу
							Route::resource('/mountings',
								'MountingController')
								->only(['index', 'show', 'update']);

							/*
							|--------------------------------------------------------------------------
							|                   БОНУСЫ ДИГИФТ
							|--------------------------------------------------------------------------
							*/
							// Добавить бонус вручную к отчету по монтажу
							Route::post('/mountings/{mounting}/digift-bonuses',
								'MountingDigiftBonusController@store')
							->name('mountings.digift-bonuses.store');

							// Отчет по бонусам
							Route::get('/digift/bonuses',
								'DigiftBonusController@index')
								->name('digift.bonuses.index');

							// Отправить бонус вручную в Дигифт
							Route::patch('/digift/bonuses/{digiftBonus}/changeBalance',
								'DigiftBonusController@changeBalance')
								->name('digift.bonuses.changeBalance');

							// Отменить бонус отчета
							Route::delete('/digift/bonuses/{digiftBonus}/rollbackBalanceChange',
								'DigiftBonusController@rollbackBalanceChange')
								->name('digift.bonuses.rollbackBalanceChange');

							// Отменить все бонусы пользователя
							Route::delete('/digift/users/{digiftUser}/rollbackBalanceChange',
								'DigiftUserController@rollbackBalanceChange')
								->name('digift.users.rollbackBalanceChange');

							// Обновить access токен пользователя вручную
							Route::patch('/digift/users/{digiftUser}/refreshToken',
								'DigiftUserController@refreshToken')
								->name('digift.users.refreshToken');
							//-------------------------------------------------------------------------

							// Отчеты по ремонту
							Route::resource('/repairs',
								'RepairController')
								->only(['index', 'show', 'update']);
							Route::post('/repairs/{repair}/message',
								'RepairController@message')
								->name('repairs.message');

							// Бонусы за монтаж
							Route::resource('/mounting-bonuses',
								'MountingBonusController')
								->except(['show']);


							// Банки
							Route::resource('/banks',
								'BankController');

							// Органищации
							Route::resource('/organizations',
								'OrganizationController');

							// Классы сложности
							Route::put('/difficulties/sort',
								'DifficultyController@sort')
								->name('difficulties.sort');
							Route::resource('/difficulties',
								'DifficultyController');

							// Тарифы на транспорт
							Route::put('/distances/sort',
								'DistanceController@sort')
								->name('distances.sort');
							Route::resource('/distances',
								'DistanceController')->except(['show']);

							// Акты
							Route::resource('/acts',
								'ActController');
							Route::get('/acts/{act}/schedule',
								'ActController@schedule')
								->name('acts.schedule');

							// Сообщения
							Route::resource('/messages',
								'MessageController')
								->only(['index', 'show']);

							// Инженеры
							Route::resource('/engineers',
								'EngineerController')
								->only(['index', 'edit', 'update']);

							// Торговые организации
							Route::resource('/trades',
								'TradeController')
								->only(['index', 'edit', 'update']);

							// Контрагенты
							Route::resource('/contragents',
								'ContragentController')
								->except(['create', 'store', 'destroy']);

							// Адреса контрагентов
							Route::resource('/contragents/{contragent}/addresses',
								'ContragentAddressController')
								->only(['edit', 'update'])
								->names([
									'edit' => 'contragents.addresses.edit',
									'update' => 'contragents.addresses.update',
								]);

							// Адреса
							Route::resource('/addresses',
								'AddressController')
								->except(['create', 'store']);

							// Телефоны адреса
							Route::resource('/addresses/{address}/phones',
								'AddressPhoneController')
								->only(['create', 'store', 'edit', 'update', 'destroy'])
								->names([
									'create' => 'addresses.phones.create',
									'store' => 'addresses.phones.store',
									'edit' => 'addresses.phones.edit',
									'update' => 'addresses.phones.update',
									'destroy' => 'addresses.phones.destroy',
								]);

							// Зоны дистрибуции адреса
							Route::resource('/addresses/{address}/regions',
								'AddressRegionController')
								->only(['index', 'store'])
								->names([
									'index' => 'addresses.regions.index',
									'store' => 'addresses.regions.store',
								]);

							// Пользователи
							Route::resource('/users',
								'UserController');
							Route::get('/users/{user}/schedule',
								'UserController@schedule')
								->name('users.schedule');
							Route::get('/users/{user}/force',
								'UserController@force')
								->name('users.force');

							// Сброс пароля пользователя
							Route::resource('/users/{user}/password',
								'UserPasswordController')
								->only(['create', 'store'])
								->names([
									'create' => 'users.password.create',
									'store' => 'users.password.store',
								]);

							// Цены пользователя
							Route::resource('/users/{user}/prices',
								'UserPriceController')
								->only(['index', 'store'])
								->names([
									'index' => 'users.prices.index',
									'store' => 'users.prices.store',
								]);

							// Узлы схемы
							Route::resource('/blocks',
								'BlockController');

							// Документация
							Route::resource('/datasheets',
								'DatasheetController');

							// Оборудование, к которому подходит документация
							Route::resource('/datasheets/{datasheet}/products',
								'DatasheetProductController')
								->only(['index', 'store'])
								->names([
									'index' => 'datasheets.products.index',
									'store' => 'datasheets.products.store',
								]);
							Route::delete('/datasheets/{datasheet}/products/destroy',
								'DatasheetProductController@destroy')
								->name('datasheets.products.destroy');

							// Аналоги
							Route::resource('/products/{product}/analogs',
								'ProductAnalogController')
								->only(['index', 'store'])
								->names([
									'index' => 'products.analogs.index',
									'store' => 'products.analogs.store',
								]);
							Route::delete('/products/{product}/analogs/destroy',
								'ProductAnalogController@destroy')
								->name('products.analogs.destroy');

							// Детали
							Route::resource('/products/{product}/details',
								'ProductDetailController')
								->only(['index', 'store'])
								->names([
									'index' => 'products.details.index',
									'store' => 'products.details.store',
								]);
							Route::delete('/products/{product}/details/destroy',
								'ProductDetailController@destroy')
								->name('products.details.destroy');

							// Подходит к
							Route::resource('/products/{product}/relations',
								'ProductRelationController')
								->only(['index', 'store'])
								->names([
									'index' => 'products.relations.index',
									'store' => 'products.relations.store',
								]);
							Route::delete('/products/{product}/relations/destroy',
								'ProductRelationController@destroy')
								->name('products.relations.destroy');

							Route::put('/product-images/{product}/sort',
								'ProductImageController@sort')
								->name('products.images.sort');

							// Каталог
							Route::put('/catalogs/sort', function (Request $request) {
								Catalog::sort($request);
							})->name('catalogs.sort');
							Route::resource('/catalogs',
								'CatalogController');
							Route::get('/catalogs/create/{catalog?}',
								'CatalogController@create')
								->name('catalogs.create.parent');
							Route::get('/tree',
								'CatalogController@tree')
								->name('catalogs.tree');

							// Товары
							Route::resource('/products',
								'ProductController');

							// Изображения товара
							Route::resource('/products/{product}/images',
								'ProductImageController')
								->only(['index', 'store'])
								->names([
									'index' => 'products.images.index',
									'store' => 'products.images.store',
								]);

							Route::put('/equipments/sort', function (Request $request) {
								Equipment::sort($request);
							})->name('equipments.sort');

							// Оборудование
							Route::resource('/equipments',
								'EquipmentController');
							Route::get('/equipments/create/{catalog?}',
								'EquipmentController@create')
								->name('equipments.create.parent');

							// Изображения оборудования
							Route::resource('/equipments/{equipment}/images',
								'EquipmentImageController')
								->only(['index', 'store'])
								->names([
									'index' => 'equipments.images.index',
									'store' => 'equipments.images.store',
								]);

							// Изображения
							Route::put('/images/sort', function (Request $request) {
								Image::sort($request);
							})->name('images.sort');

							Route::resource('/images',
								'ImageController')
								->only(['index', 'store', 'show', 'destroy']);

							Route::resource('/files',
								'FileController')
								->only(['index', 'store', 'show', 'destroy']);

							// Серийные номера
							Route::resource('/serials',
								'SerialController')
								->only(['index', 'create', 'store']);

							// Сертификаты
							Route::resource('/certificates',
								'CertificateController')
								->only(['index', 'destroy']);
							Route::get('/certificates/create/{certificate_type}',
								'CertificateController@create')
								->name('certificates.create');
							Route::post('/certificates/{certificate_type}',
								'CertificateController@store')
								->name('certificates.store');

							// Валюта
							Route::resource('/currencies',
								'CurrencyController');
							Route::resource('/currency_archives',
								'CurrencyArchiveController')->only(['index']);

							// Типы товаров
							Route::resource('/product_types',
								'ProductTypeController');

							// Типы цен
							Route::resource('/price_types',
								'PriceTypeController')
								->except(['create', 'store', 'destroy']);

							// Типы файлов
							Route::resource('/file_types',
								'FileTypeController');

							// Группы файлов
							Route::resource('/file_groups',
								'FileGroupController');

							// Склады
							Route::resource('/warehouses',
								'WarehouseController');

							// Страницы
							Route::resource('/pages',
								'PageController');

							//Контакты
							Route::resource('/contacts',
								'ContactController');

							// Телефоны
							Route::resource('/phones',
								'PhoneController')
								->except(['show']);

							// Заказы
							Route::resource('/orders',
								'OrderController')
								->only(['index', 'show', 'update']);
							Route::post('/orders/{order}/message',
								'OrderController@message')
								->name('orders.message');
							Route::resource('/order-items',
								'OrderItemController')
							->only(['destroy', 'update']);
							Route::get('/orders/{order}/schedule',
								'OrderController@schedule')
								->name('orders.schedule');
							Route::post('/orders/{order}/payment',
								'OrderController@payment')
								->name('orders.payment');

							// Типы мероприятий
							Route::put('/event_types/sort', function (Request $request) {
								EventType::sort($request);
							})->name('event_types.sort');
							Route::resource('/event_types',
								'EventTypeController');

							// Мероприятия
							Route::resource('/events',
								'EventController');
							Route::get('/events/{event}/mailing',
								'EventController@mailing')
								->name('events.mailing');
							Route::get('/events/{event}/attachment',
								'EventController@attachment')
								->name('events.attachment');
							Route::get('/events/create/{member?}',
								'EventController@create')
								->name('events.create');
							Route::post('/events/store/{member?}',
								'EventController@store')
								->name('events.store');

							Route::resource('/parts',
								'PartController')
								->only(['edit', 'update', 'destroy']);


							Route::resource('/members',
								'MemberController');

							Route::resource('/elements',
								'ElementController');
							Route::resource('/pointers',
								'PointerController');
							Route::resource('/shapes',
								'ShapeController');

							Route::resource('/templates',
								'TemplateController');

							Route::get('/participants/create/{member}',
								'ParticipantController@create')
								->name('participants.create');
							Route::post('/participants/store/{member}',
								'ParticipantController@store')
								->name('participants.store');
							Route::resource('/participants',
								'ParticipantController')
								->only(['destroy']);

							// Новости
							Route::post('/announcements/image',
								'AnnouncementController@image')
								->name('announcements.image');
							Route::resource('/announcements',
								'AnnouncementController');

							Route::post('/schemes/image',
								'SchemeController@image')
								->name('schemes.image');
							Route::get('/schemes/{scheme}/pointers',
								'SchemeController@pointers')
								->name('schemes.pointers');
							Route::get('/schemes/{scheme}/shapes',
								'SchemeController@shapes')
								->name('schemes.shapes');
							Route::get('/schemes/{scheme}/elements',
								'SchemeController@elements')
								->name('schemes.elements');
							Route::post('/schemes/{scheme}/elements',
								'SchemeController@elements')
								->name('schemes.elements.update');
							Route::delete('/schemes/{scheme}/elements',
								'SchemeController@elements')
								->name('schemes.elements.delete');
							Route::resource('/schemes',
								'SchemeController');

							// Рассылка пользователям
							Route::resource('/mailings',
								'MailingController')
								->only(['create', 'store']);

							Route::resource('/prices',
								'PriceController');

							Route::put('/blocks/sort', function (Request $request) {
								Block::sort($request);
							})->name('blocks.sort');


							Route::put('/elements/sort', function (Request $request) {
								Element::sort($request);
							})->name('elements.sort');

							Route::put('/file_types/sort', function (Request $request) {
								FileType::sort($request);
							})->name('file_types.sort');

							// Договора
							Route::resource('/contracts',
								'ContractController')
								->only(['index', 'show']);

							Route::get('/contracts/{contract}/download', function (Contract $contract) {
								(new ContractWordProcessor($contract))->render();
							})->name('contracts.download');

							// Типы договоров
							Route::resource('/contract-types',
								'ContractTypeController');

							// Склады дистрибьютора
							Route::resource('/storehouses',
								'StorehouseController')
								->only(['index', 'show', 'create', 'store']);
								
							// Отчеты
							Route::resource('/reports/asc',
								'ReportAscController');
						});

					});
			});
	});

Route::group([
	'namespace' => 'Api',
	'prefix' => 'api',
],
	function () {

		// Товары для отчета по монтажу
		Route::name('api')->get('/products/mounting',
			'ProductController@mounting');

		// Товары для заявки на монтаж
		Route::get('/products/mounter',
			'ProductController@mounter')
			->name('api.products.mounter');

		// Товары для отчета по ремонту
		Route::name('api')->get('/parts',
			'PartController@index')
			->name('.parts.index');
		Route::name('api')->get('/parts/create/{product}',
			'PartController@create')
			->name('.parts.create');


		// Сервисные центры на карте
		Route::name('api')->get('/services/{region?}',
			'MapController@service_centers')
			->name('.service-centers');

		// Дилеры на карте
		Route::name('api')->get('/dealers/{region?}',
			'MapController@where_to_buy')
			->name('.where-to-buy');

		// Монтажники на карте
		Route::name('api')->get('/mounters/{region?}',
			'MapController@mounter_requests')
			->name('.mounter-requests');

		// Пользователи
		Route::name('api')->resource('/users',
			'UserController')
			->only(['show']);

		// Заказы
		Route::name('api')->resource('/orders',
			'OrderController')
			->only(['show']);

		// Акты выполненных работ
		Route::name('api')->resource('/acts',
			'ActController')
			->only(['show']);

		// Быстрый заказ
		Route::get('/products/fast',
			'ProductController@fast')
			->name('api.products.fast');


		Route::name('api')->get('/products/analog', 'ProductController@analog');
		Route::name('api')->get('/products/product', 'ProductController@product');

		//Route::name('api')->get('/products/datasheet', 'ProductController@datasheet');


		Route::name('api')->get('/products/{product}', 'ProductController@show');
		//
		//Route::name('api')->get('/boilers', 'BoilerController@index')->name('.boilers.search');
		//Route::name('api')->get('/boilers/{product}', 'BoilerController@show')->name('.boilers.show');

		Route::name('api')->get('/storehouses/cron',
			'StorehouseController@cron')
			->name('.storehouses.cron');
	});
