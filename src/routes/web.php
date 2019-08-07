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
//                    Route::post('/unsubscribe/success',
//                        'UnsubscribeController@success')
//                        ->name('unsubscribe.success');

        Route::get('/upload/test', function () {
            return response('<yml_catalog date="2019-06-21 10:11">
                                <shop>
                                <name></name><company></company><url></url><phone></phone><email></email>
                                <platform></platform><version></version><currencies><currency id="RUB" rate="1"/><currency id="EUR" rate="CBRF"/></currencies>
                                <categories><category id="4"></category></categories>
                                <offers>
                                    <offer id="00033746000000000000" available="true">
                                    <url></url>	<price></price>	<currencyId></currencyId>	<categoryId></categoryId>	<picture></picture>	<delivery></delivery><name>Генератор термоэлектрический</name>
                                    <vendor>Ferroli</vendor>
                                    <vendorCode>39849670</vendorCode>
                                    <quantity>13</quantity>
                                    <description/><sales_notes></sales_notes><manufacturer_warranty>true</manufacturer_warranty><country_of_origin></country_of_origin><market_category>Дом и дача/Строительство и ремонт/Отопление/Элементы систем отопления</market_category>
                                    </offer>
                                </offers></shop></yml_catalog>', 200)
                ->header('Content-Type', 'text/xml');
        })
            ->name('storehouses.test');

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
                        'create'  => 'addresses.phones.create',
                        'store'   => 'addresses.phones.store',
                        'edit'    => 'addresses.phones.edit',
                        'update'  => 'addresses.phones.update',
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

                // Ввод в экплуатацию
//                            Route::resource('/launches',
//                                'LaunchController')
//                                ->middleware('permission:launches')
//                                ->except(['show']);

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
                        'edit'   => 'contragents.addresses.edit',
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
                        'create'  => 'contacts.phones.create',
                        'store'   => 'contacts.phones.store',
                        'edit'    => 'contacts.phones.edit',
                        'update'  => 'contacts.phones.update',
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
                        Route::put('/distributors/{order}',
                            'DistributorController@update')
                            ->name('distributors.update');
                        Route::post('/distributors/{order}/message',
                            'DistributorController@message')
                            ->name('distributors.message');
                        Route::get('/distributors/{order}/excel', function (Order $order) {
                            (new OrderExcel())->setModel($order)->render();
                        })->name('distributors.excel');
                    });


                // Заказы
                Route::post('/orders/load',
                    'OrderController@load')
                    ->middleware('permission:orders')
                    ->name('orders.load');
                Route::resource('/orders',
                    'OrderController')
                    ->except(['edit', 'update'])->middleware('permission:orders');
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
                //

                Route::delete('/order-items/{item}',
                    'OrderItemController@destroy')
                    ->name('orders.items.destroy');

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
//                Route::group(['middleware' => ['permission:storehouses']],
//                    function () {
//
//                        Route::resource('/storehouses',
//                            'StorehouseController');
//
//                        Route::post('/storehouses/{storehouse}/excel',
//                            'StorehouseExcelController@store')
//                            ->name('storehouses.excel.store');
//
//
//                        Route::post('/storehouses/{storehouse}/url',
//                            'StorehouseUrlController@store')
//                            ->name('storehouses.url.store');
//                    });


            });
        Route::group([
            'middleware' => ['auth', 'admin'],
            'prefix'     => 'admin',
        ],
            function () {

                // Панель управления
                Route::name('admin')->get('/',
                    'Admin\IndexController@index');

                // Авторизации
                Route::name('admin')->resource('/authorization-brands',
                    'Admin\AuthorizationBrandController')
                    ->except(['delete']);
                Route::name('admin')->resource('/authorization-roles',
                    'Admin\AuthorizationRoleController')
                    ->except(['delete', 'show', 'create']);
                Route::name('admin')->get('/authorization-roles/create/{role}',
                    'Admin\AuthorizationRoleController@create')
                    ->name('.authorization-roles.create');
                Route::name('admin')->resource('/authorization-types',
                    'Admin\AuthorizationTypeController')
                    ->except(['delete']);
                Route::name('admin')->resource('/authorizations',
                    'Admin\AuthorizationController')
                    ->except(['delete']);
                Route::name('admin')->resource('/mounters',
                    'Admin\MounterController')
                    ->except(['delete']);
                Route::name('admin')->post('/authorizations/{authorization}/message',
                    'Admin\AuthorizationController@message')
                    ->name('.authorizations.message');

                // Роуты
                Route::name('admin')->get('routes',
                    'Admin\RouteController@index')
                    ->name('.routes.index');

                // Отчеты по монтажу
                Route::name('admin')->resource('/mountings',
                    'Admin\MountingController')
                    ->only(['index', 'show', 'update']);

                // Отчеты по ремонту
                Route::name('admin')->resource('/repairs',
                    'Admin\RepairController')
                    ->only(['index', 'show', 'update']);
                Route::name('admin')->post('/repairs/{repair}/message',
                    'Admin\RepairController@message')
                    ->name('.repairs.message');

                // Бонусы за монтаж
                Route::name('admin')->resource('/mounting-bonuses',
                    'Admin\MountingBonusController')
                    ->except(['show']);


                // Банки
                Route::name('admin')->resource('/banks',
                    'Admin\BankController');

                // Органищации
                Route::name('admin')->resource('/organizations',
                    'Admin\OrganizationController');

                // Классы сложности
                Route::name('admin')->put('/difficulties/sort',
                    'Admin\DifficultyController@sort')
                    ->name('.difficulties.sort');
                Route::name('admin')->resource('/difficulties',
                    'Admin\DifficultyController');

                // Тарифы на транспорт
                Route::name('admin')->put('/distances/sort',
                    'Admin\DistanceController@sort')
                    ->name('.distances.sort');
                Route::name('admin')->resource('/distances',
                    'Admin\DistanceController')->except(['show']);

                // Акты
                Route::name('admin')->resource('/acts',
                    'Admin\ActController');
                Route::name('admin')->get('/acts/{act}/schedule',
                    'Admin\ActController@schedule')
                    ->name('.acts.schedule');

                // Сообщения
                Route::name('admin')->resource('/messages',
                    'Admin\MessageController')
                    ->only(['index', 'show']);

                // Инженеры
                Route::name('admin')->resource('/engineers',
                    'Admin\EngineerController')
                    ->only(['index', 'edit', 'update']);

                // Торговые организации
                Route::name('admin')->resource('/trades',
                    'Admin\TradeController')
                    ->only(['index', 'edit', 'update']);

                // Ввод в эксплуатацию
//                                Route::name('admin')->resource('/launches',
//                                    'Admin\LaunchController')
//                                    ->only(['index', 'edit', 'update']);

                // Контрагенты
                Route::name('admin')->resource('/contragents',
                    'Admin\ContragentController')
                    ->except(['create', 'store', 'destroy']);

                // Адреса контрагентов
                Route::name('admin')->resource('/contragents/{contragent}/addresses',
                    'Admin\ContragentAddressController')
                    ->only(['edit', 'update'])
                    ->names([
                        'edit'   => 'admin.contragents.addresses.edit',
                        'update' => 'admin.contragents.addresses.update',
                    ]);

                // Адреса
                Route::name('admin')->resource('/addresses',
                    'Admin\AddressController')
                    ->except(['create', 'store']);

                // Телефоны адреса
                Route::name('admin')->resource('/addresses/{address}/phones',
                    'Admin\AddressPhoneController')
                    ->only(['create', 'store', 'edit', 'update', 'destroy'])
                    ->names([
                        'create'  => 'admin.addresses.phones.create',
                        'store'   => 'admin.addresses.phones.store',
                        'edit'    => 'admin.addresses.phones.edit',
                        'update'  => 'admin.addresses.phones.update',
                        'destroy' => 'admin.addresses.phones.destroy',
                    ]);

                // Зоны дистрибуции адреса
                Route::name('admin')->resource('/addresses/{address}/regions',
                    'Admin\AddressRegionController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.addresses.regions.index',
                        'store' => 'admin.addresses.regions.store',
                    ]);

                // Пользователи
                Route::name('admin')->resource('/users',
                    'Admin\UserController');
                Route::name('admin')->get('/users/{user}/schedule',
                    'Admin\UserController@schedule')
                    ->name('.users.schedule');
                Route::name('admin')->get('/users/{user}/force',
                    'Admin\UserController@force')
                    ->name('.users.force');

                // Сброс пароля пользователя
                Route::name('admin')->resource('/users/{user}/password',
                    'Admin\UserPasswordController')
                    ->only(['create', 'store'])
                    ->names([
                        'create' => 'admin.users.password.create',
                        'store'  => 'admin.users.password.store',
                    ]);

                // Цены пользователя
                Route::name('admin')->resource('/users/{user}/prices',
                    'Admin\UserPriceController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.users.prices.index',
                        'store' => 'admin.users.prices.store',
                    ]);

                // Узлы схемы
                Route::name('admin')->resource('/blocks',
                    'Admin\BlockController');

                // Документация
                Route::name('admin')->resource('/datasheets',
                    'Admin\DatasheetController');

                // Оборудование, к которому подходит документация
                Route::resource('/datasheets/{datasheet}/products',
                    'Admin\DatasheetProductController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.datasheets.products.index',
                        'store' => 'admin.datasheets.products.store',
                    ]);
                Route::name('admin')->delete('/datasheets/{datasheet}/products/destroy',
                    'Admin\DatasheetProductController@destroy')
                    ->name('.datasheets.products.destroy');

                // Аналоги
                Route::resource('/products/{product}/analogs',
                    'Admin\ProductAnalogController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.products.analogs.index',
                        'store' => 'admin.products.analogs.store',
                    ]);
                Route::name('admin')->delete('/products/{product}/analogs/destroy',
                    'Admin\ProductAnalogController@destroy')
                    ->name('.products.analogs.destroy');

                // Детали
                Route::resource('/products/{product}/details',
                    'Admin\ProductDetailController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.products.details.index',
                        'store' => 'admin.products.details.store',
                    ]);
                Route::name('admin')->delete('/products/{product}/details/destroy',
                    'Admin\ProductDetailController@destroy')
                    ->name('.products.details.destroy');

                // Подходит к
                Route::resource('/products/{product}/relations',
                    'Admin\ProductRelationController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.products.relations.index',
                        'store' => 'admin.products.relations.store',
                    ]);
                Route::name('admin')->delete('/products/{product}/relations/destroy',
                    'Admin\ProductRelationController@destroy')
                    ->name('.products.relations.destroy');

                Route::name('admin')->put('/product-images/{product}/sort',
                    'ProductImageController@sort')
                    ->name('.products.images.sort');

                // Каталог
                Route::name('admin')->put('/catalogs/sort', function (Request $request) {
                    Catalog::sort($request);
                })->name('.catalogs.sort');
                Route::name('admin')->resource('/catalogs',
                    'Admin\CatalogController');
                Route::name('admin')->get('/catalogs/create/{catalog?}',
                    'Admin\CatalogController@create')
                    ->name('.catalogs.create.parent');
                Route::name('admin')->get('/tree',
                    'Admin\CatalogController@tree')
                    ->name('.catalogs.tree');

                // Товары
                Route::name('admin')->resource('/products',
                    'Admin\ProductController');

                // Изображения товара
                Route::resource('/products/{product}/images',
                    'Admin\ProductImageController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.products.images.index',
                        'store' => 'admin.products.images.store',
                    ]);

                Route::name('admin')->put('/equipments/sort', function (Request $request) {
                    Equipment::sort($request);
                })->name('.equipments.sort');

                // Оборудование
                Route::name('admin')->resource('/equipments',
                    'Admin\EquipmentController');
                Route::name('admin')->get('/equipments/create/{catalog?}',
                    'Admin\EquipmentController@create')
                    ->name('.equipments.create.parent');

                // Изображения оборудования
                Route::resource('/equipments/{equipment}/images',
                    'Admin\EquipmentImageController')
                    ->only(['index', 'store'])
                    ->names([
                        'index' => 'admin.equipments.images.index',
                        'store' => 'admin.equipments.images.store',
                    ]);

                // Изображения
                Route::name('admin')->put('/images/sort', function (Request $request) {
                    Image::sort($request);
                })->name('.images.sort');

                Route::name('admin')->resource('/images',
                    'Admin\ImageController')
                    ->only(['index', 'store', 'show', 'destroy']);

                Route::name('admin')->resource('/files',
                    'Admin\FileController')
                    ->only(['index', 'store', 'show', 'destroy']);

                // Серийные номера
                Route::name('admin')->resource('/serials',
                    'Admin\SerialController')
                    ->only(['index', 'create', 'store']);

                // Сертификаты
                Route::name('admin')->resource('/certificates',
                    'Admin\CertificateController')
                    ->only(['index', 'destroy']);
                Route::get('/certificates/create/{certificate_type}',
                    'Admin\CertificateController@create')
                    ->name('admin.certificates.create');
                Route::post('/certificates/{certificate_type}',
                    'Admin\CertificateController@store')
                    ->name('admin.certificates.store');

                // Валюта
                Route::name('admin')->resource('/currencies',
                    'Admin\CurrencyController');
                Route::name('admin')->resource('/currency_archives',
                    'Admin\CurrencyArchiveController')->only(['index']);

                // Типы товаров
                Route::name('admin')->resource('/product_types',
                    'Admin\ProductTypeController');

                // Типы цен
                Route::name('admin')->resource('/price_types',
                    'Admin\PriceTypeController')
                    ->except(['create', 'store', 'destroy']);

                // Типы файлов
                Route::name('admin')->resource('/file_types',
                    'Admin\FileTypeController');

                // Группы файлов
                Route::name('admin')->resource('/file_groups',
                    'Admin\FileGroupController');

                // Склады
                Route::name('admin')->resource('/warehouses',
                    'Admin\WarehouseController');

                // Страницы
                Route::name('admin')->resource('/pages',
                    'Admin\PageController');

                //Контакты
                Route::name('admin')->resource('/contacts',
                    'Admin\ContactController');

                // Телефоны
                Route::name('admin')->resource('/phones',
                    'Admin\PhoneController')
                    ->except(['show']);

                // Заказы
                Route::name('admin')->resource('/orders',
                    'Admin\OrderController')
                    ->only(['index', 'show', 'destroy']);
                Route::name('admin')->post('/orders/{order}/message',
                    'Admin\OrderController@message')
                    ->name('.orders.message');
                Route::name('admin')->delete('/order-items/{item}',
                    'Admin\OrderItemController@destroy')
                    ->name('.orders.items.destroy');
                Route::name('admin')->get('/orders/{order}/schedule',
                    'Admin\OrderController@schedule')
                    ->name('.orders.schedule');

                // Типы мероприятий
                Route::name('admin')->put('/event_types/sort', function (Request $request) {
                    EventType::sort($request);
                })->name('.event_types.sort');
                Route::name('admin')->resource('/event_types',
                    'Admin\EventTypeController');

                // Мероприятия
                Route::name('admin')->resource('/events',
                    'Admin\EventController');
                Route::name('admin')->get('/events/{event}/mailing',
                    'Admin\EventController@mailing')
                    ->name('.events.mailing');
                Route::name('admin')->get('/events/{event}/attachment',
                    'Admin\EventController@attachment')
                    ->name('.events.attachment');
                Route::name('admin')->get('/events/create/{member?}',
                    'Admin\EventController@create')
                    ->name('.events.create');
                Route::name('admin')->post('/events/store/{member?}',
                    'Admin\EventController@store')
                    ->name('.events.store');

                Route::name('admin')->resource('/parts',
                    'Admin\PartController')
                    ->only(['edit', 'update', 'destroy']);


                Route::name('admin')->resource('/members',
                    'Admin\MemberController');

                Route::name('admin')->resource('/elements',
                    'Admin\ElementController');
                Route::name('admin')->resource('/pointers',
                    'Admin\PointerController');
                Route::name('admin')->resource('/shapes',
                    'Admin\ShapeController');

                Route::name('admin')->resource('/templates',
                    'Admin\TemplateController');

                Route::name('admin')->get('/participants/create/{member}',
                    'Admin\ParticipantController@create')
                    ->name('.participants.create');
                Route::name('admin')->post('/participants/store/{member}',
                    'Admin\ParticipantController@store')
                    ->name('.participants.store');
                Route::name('admin')->resource('/participants',
                    'Admin\ParticipantController')
                    ->only(['destroy']);

                // Новости
                Route::name('admin')->post('/announcements/image',
                    'Admin\AnnouncementController@image')
                    ->name('.announcements.image');
                Route::name('admin')->resource('/announcements',
                    'Admin\AnnouncementController');

                Route::name('admin')->post('/schemes/image',
                    'Admin\SchemeController@image')
                    ->name('.schemes.image');
                Route::name('admin')->get('/schemes/{scheme}/pointers',
                    'Admin\SchemeController@pointers')
                    ->name('.schemes.pointers');
                Route::name('admin')->get('/schemes/{scheme}/shapes',
                    'Admin\SchemeController@shapes')
                    ->name('.schemes.shapes');
                Route::name('admin')->get('/schemes/{scheme}/elements',
                    'Admin\SchemeController@elements')
                    ->name('.schemes.elements');
                Route::name('admin')->post('/schemes/{scheme}/elements',
                    'Admin\SchemeController@elements')
                    ->name('.schemes.elements.update');
                Route::name('admin')->delete('/schemes/{scheme}/elements',
                    'Admin\SchemeController@elements')
                    ->name('.schemes.elements.delete');
                Route::name('admin')->resource('/schemes',
                    'Admin\SchemeController');

                // Рассылка пользователям
                Route::name('admin')->resource('/mailings',
                    'Admin\MailingController')
                    ->only(['create', 'store']);

                Route::name('admin')->resource('/prices',
                    'Admin\PriceController');

                Route::name('admin')->put('/blocks/sort', function (Request $request) {
                    Block::sort($request);
                })->name('.blocks.sort');


                Route::name('admin')->put('/elements/sort', function (Request $request) {
                    Element::sort($request);
                })->name('.elements.sort');

                Route::name('admin')->put('/file_types/sort', function (Request $request) {
                    FileType::sort($request);
                })->name('.file_types.sort');

                // Договора
                Route::name('admin')->resource('/contracts',
                    'Admin\ContractController')
                    ->only(['index', 'show']);

                Route::get('/contracts/{contract}/download', function (Contract $contract) {
                    (new ContractWordProcessor($contract))->render();
                })->name('admin.contracts.download');

                // Типы договоров
                Route::name('admin')->resource('/contract-types',
                    'Admin\ContractTypeController');

//                Route::name('admin')->resource('/storehouses',
//                    'Admin\StorehouseController');

            });
    });

Route::get('/register/confirm/{token}', 'Auth\RegisterController@confirm')->name('confirm');

Route::group([
    'namespace' => 'Api',
    'prefix'    => 'api',
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
        Route::name('api')->get('/boilers', 'BoilerController@index')->name('.boilers.search');
        Route::name('api')->get('/boilers/{product}', 'BoilerController@show')->name('.boilers.show');
    });