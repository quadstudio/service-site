<?php

namespace QuadStudio\Service\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Exports\Excel\OrderExcel;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Models\Block;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Models\Currency;
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

class Site
{

    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Lock constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param Models\Currency $cost_currency
     * @param Models\Currency $user_currency
     * @param null $date
     * @return float
     */
    public static function currencyRates(Models\Currency $cost_currency, Models\Currency $user_currency, $date = null)
    {
        if ($cost_currency->getKey() == $user_currency->getKey()) {
            return 1;
        }
        $currency = ($user_currency->getAttribute('rates') == 1) ? $cost_currency : $user_currency;

//        if ($user_currency->getAttribute('rates') == 1) {
//            return $cost_currency->getAttribute('rates');
//        } else {
//            return $user_currency->getAttribute('rates');
//        }
        if (is_null($date)) {
            return $currency->getAttribute('rates');
        } else {
            if (($result = $currency->archives()->where('date', $date))->exists()) {
                return $result->first()->getAttribute('rates');
            } else {
                return 0.00;
            }
        }
    }

    /**
     * Service Web Routes
     */
    public function routes()
    {

        ($router = $this->app->make('router'))
            ->group(['middleware' => ['online']],
                function () use ($router) {

                    // Главная страница
                    $router->get('/',
                        '\QuadStudio\Service\Site\Http\Controllers\IndexController@index')
                        ->name('index');

                    // Интернет-магазины
                    $router->match(['get', 'post'], '/eshop',
                        '\QuadStudio\Service\Site\Http\Controllers\MapController@online_stores')
                        ->name('online-stores');

                    // Где купить
                    $router->match(['get', 'post'], '/dealers',
                        '\QuadStudio\Service\Site\Http\Controllers\MapController@where_to_buy')
                        ->name('where-to-buy');

                    // Сервисные центры
                    $router->match(['get', 'post'], '/services',
                        '\QuadStudio\Service\Site\Http\Controllers\MapController@service_centers')
                        ->name('service-centers');

                    // Заявки на монтаж
                    $router->match(['get', 'post'], '/mounter-requests',
                        '\QuadStudio\Service\Site\Http\Controllers\MapController@mounter_requests')
                        ->name('mounter-requests');
                    $router->get('/mounters/create/{address}',
                        '\QuadStudio\Service\Site\Http\Controllers\MounterController@create')
                        ->name('mounters.create');
                    $router->post('/mounters/{address}',
                        '\QuadStudio\Service\Site\Http\Controllers\MounterController@store')
                        ->name('mounters.store');
                    $router->resource('/mounters',
                        '\QuadStudio\Service\Site\Http\Controllers\MounterController')
                        ->only(['index', 'show', 'edit', 'update']);

                    // Файлы
                    $router->resource('/files',
                        '\QuadStudio\Service\Site\Http\Controllers\FileController')
                        ->only(['index', 'store', 'show', 'destroy']);

                    // Каталог
                    $router->resource('/catalogs',
                        '\QuadStudio\Service\Site\Http\Controllers\CatalogController')
                        ->only(['index', 'show']);
                    $router->get('/catalogs/{catalog}/list',
                        '\QuadStudio\Service\Site\Http\Controllers\CatalogController@list')
                        ->name('catalogs.list');

                    // Оборудование
                    $router->resource('/equipments',
                        '\QuadStudio\Service\Site\Http\Controllers\EquipmentController')
                        ->only(['index', 'show']);

                    // Техдокументация
                    $router->resource('/datasheets',
                        '\QuadStudio\Service\Site\Http\Controllers\DatasheetController')
                        ->only(['index', 'show']);

                    // Витрина товаров
                    $router->get('/products/list',
                        '\QuadStudio\Service\Site\Http\Controllers\ProductController@list')
                        ->name('products.list');
                    $router->resource('/products',
                        '\QuadStudio\Service\Site\Http\Controllers\ProductController')
                        ->only(['index', 'show']);
                    $router->get('/products/{product}/schemes/{scheme}',
                        '\QuadStudio\Service\Site\Http\Controllers\ProductController@scheme')
                        ->name('products.scheme');

                    // Новости
                    $router->resource('/announcements',
                        '\QuadStudio\Service\Site\Http\Controllers\AnnouncementController')
                        ->only(['index']);

                    // Обновление курсов валют
                    $router->get('/currencies/refresh/',
                        '\QuadStudio\Service\Site\Http\Controllers\CurrencyController@refresh')
                        ->name('currencies.refresh');

                    // Static pages
                    $router->get('/feedback',
                        '\QuadStudio\Service\Site\Http\Controllers\StaticPageController@feedback')
                        ->name('feedback');
                    $router->post('/feedback',
                        '\QuadStudio\Service\Site\Http\Controllers\StaticPageController@message')
                        ->name('message');


                    /* Мероприятия */
                    $router->resource('/events',
                        '\QuadStudio\Service\Site\Http\Controllers\EventController')
                        ->only(['show']);

                    /* Типы мероприятий */
                    $router->resource('/event-types',
                        '\QuadStudio\Service\Site\Http\Controllers\EventTypeController')
                        ->only(['show'])
                        ->names([
                            'show' => 'event_types.show',
                        ]);

                    /* Заявки */
                    $router->get('/members/confirm/{token}',
                        '\QuadStudio\Service\Site\Http\Controllers\MemberController@confirm')
                        ->name('members.confirm');
                    $router->resource('/members',
                        '\QuadStudio\Service\Site\Http\Controllers\MemberController')
                        ->only(['index', 'store']);
                    $router->get('/members/register/{event}',
                        '\QuadStudio\Service\Site\Http\Controllers\MemberController@register')
                        ->name('members.register');
                    $router->get('/members/create/{event_type}',
                        '\QuadStudio\Service\Site\Http\Controllers\MemberController@create')
                        ->name('members.create');

                    /* Участники */
                    $router->resource('/participants',
                        '\QuadStudio\Service\Site\Http\Controllers\ParticipantController')
                        ->only(['create']);

                    $router->group(['middleware' => ['auth']],
                        function () use ($router) {
                            // Личный кабинет
                            $router->get('/home',
                                '\QuadStudio\Service\Site\Http\Controllers\HomeController@index')
                                ->name('home');
                            $router->post('/home/logo',
                                '\QuadStudio\Service\Site\Http\Controllers\HomeController@logo')
                                ->name('home.logo');
                            $router->get('/users/{user}/force',
                                '\QuadStudio\Service\Site\Http\Controllers\HomeController@force')
                                ->name('users.admin');

                            // Авторизации
                            $router->resource('/authorizations',
                                '\QuadStudio\Service\Site\Http\Controllers\AuthorizationController')
                                ->middleware('permission:authorizations')
                                ->only(['index', 'store', 'show']);
                            $router->post('/authorizations/{authorization}/message',
                                '\QuadStudio\Service\Site\Http\Controllers\AuthorizationController@message')
                                ->middleware('permission:messages')
                                ->name('authorizations.message');
                            $router->get('/authorizations/create/{role}',
                                '\QuadStudio\Service\Site\Http\Controllers\AuthorizationController@create')
                                ->name('authorizations.create')
                                ->middleware('permission:authorizations');

                            // Адреса
                            $router->resource('/addresses',
                                '\QuadStudio\Service\Site\Http\Controllers\AddressController')
                                ->middleware('permission:addresses')
                                ->except(['create']);
                            $router->get('/addresses/create/{address_type}',
                                '\QuadStudio\Service\Site\Http\Controllers\AddressController@create')
                                ->middleware('permission:addresses')
                                ->name('addresses.create');

                            // Телефоны адреса
                            $router->resource('/addresses/{address}/phones',
                                '\QuadStudio\Service\Site\Http\Controllers\AddressPhoneController')
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
                            $router->resource('/engineers',
                                '\QuadStudio\Service\Site\Http\Controllers\EngineerController')
                                ->middleware('permission:engineers')
                                ->except(['show']);

                            // Отчеты по монтажу
                            $router->resource('/mountings',
                                '\QuadStudio\Service\Site\Http\Controllers\MountingController')
                                ->middleware('permission:mountings')
                                ->only(['index', 'create', 'store', 'show']);
                            $router->post('/mountings/{mounting}/message',
                                '\QuadStudio\Service\Site\Http\Controllers\MountingController@message')
                                ->middleware('permission:messages')
                                ->name('mountings.message');
                            $router->get('/mountings/{mounting}/pdf', function (Mounting $mounting) {
                                return (new MountingPdf())->setModel($mounting)->render();
                            })->middleware('can:pdf,mounting')
                                ->name('mountings.pdf');

                            // Торговые организации
                            $router->resource('/trades',
                                '\QuadStudio\Service\Site\Http\Controllers\TradeController')
                                ->middleware('permission:trades')
                                ->except(['show']);

                            // Ввод в экплуатацию
                            $router->resource('/launches',
                                '\QuadStudio\Service\Site\Http\Controllers\LaunchController')
                                ->middleware('permission:launches')
                                ->except(['show']);

                            // Сообщения
                            $router->resource('/messages',
                                '\QuadStudio\Service\Site\Http\Controllers\MessageController')
                                ->middleware('permission:messages')
                                ->only(['index', 'show']);

                            // Отчеты по ремонту
                            $router->resource('/repairs',
                                '\QuadStudio\Service\Site\Http\Controllers\RepairController')
                                ->middleware('permission:repairs');
                            $router->post('/repairs/{repair}/message',
                                '\QuadStudio\Service\Site\Http\Controllers\RepairController@message')
                                ->middleware('permission:messages')
                                ->name('repairs.message');
                            $router->get('/repairs/{repair}/pdf', function (Repair $repair) {
                                return (new RepairPdf())->setModel($repair)->render();
                            })->middleware('can:pdf,repair')->name('repairs.pdf');

                            // Контрагенты
                            $router->resource('/contragents',
                                '\QuadStudio\Service\Site\Http\Controllers\ContragentController')
                                ->middleware('permission:contragents');
                            $router->resource('/contragents/{contragent}/addresses',
                                '\QuadStudio\Service\Site\Http\Controllers\ContragentAddressController')
                                ->middleware('permission:addresses')
                                ->only(['edit', 'update'])
                                ->names([
                                    'edit'   => 'contragents.addresses.edit',
                                    'update' => 'contragents.addresses.update',
                                ]);

                            // Контакты
                            $router->resource('/contacts',
                                '\QuadStudio\Service\Site\Http\Controllers\ContactController')
                                ->middleware('permission:contacts');

                            // Телефоны контакта
                            $router->resource('/contacts/{contact}/phones',
                                '\QuadStudio\Service\Site\Http\Controllers\ContactPhoneController')
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
                            $router
                                ->group(['middleware' => ['permission:distributors']],
                                    function () use ($router) {
                                        $router->get('/distributors',
                                            '\QuadStudio\Service\Site\Http\Controllers\DistributorController@index')
                                            ->name('distributors.index');
                                        $router->get('/distributors/{order}',
                                            '\QuadStudio\Service\Site\Http\Controllers\DistributorController@show')
                                            ->name('distributors.show');
                                        $router->put('/distributors/{order}',
                                            '\QuadStudio\Service\Site\Http\Controllers\DistributorController@update')
                                            ->name('distributors.update');
                                        $router->post('/distributors/{order}/message',
                                            '\QuadStudio\Service\Site\Http\Controllers\DistributorController@message')
                                            ->name('distributors.message');
                                        $router->get('/distributors/{order}/excel', function (Order $order) {
                                            (new OrderExcel())->setModel($order)->render();
                                        })->name('distributors.excel');
                                    });


                            // Заказы
                            $router->post('/orders/load',
                                '\QuadStudio\Service\Site\Http\Controllers\OrderController@load')
                                ->middleware('permission:orders')
                                ->name('orders.load');
                            $router->resource('/orders',
                                '\QuadStudio\Service\Site\Http\Controllers\OrderController')
                                ->except(['edit', 'update'])->middleware('permission:orders');
                            $router->post('/orders/{order}/message',
                                '\QuadStudio\Service\Site\Http\Controllers\OrderController@message')
                                ->middleware('permission:messages')
                                ->name('orders.message');

                            // Акты
                            $router->resource('/acts',
                                '\QuadStudio\Service\Site\Http\Controllers\ActController')
                                ->middleware('permission:acts')
                                ->except(['destroy']);
                            $router->get('/acts/{act}/pdf', function (Act $act) {
                                return (new ActPdf())->setModel($act)->render();
                            })->middleware('can:pdf,act')->name('acts.pdf');

                            // Корзина
                            $router->get('/cart',
                                '\QuadStudio\Service\Site\Http\Controllers\CartController@index')
                                ->name('cart');
                            $router->post('/cart/{product}/add',
                                '\QuadStudio\Service\Site\Http\Controllers\CartController@add')
                                ->name('buy');
                            $router->delete('/cart/remove',
                                '\QuadStudio\Service\Site\Http\Controllers\CartController@remove')
                                ->name('removeCartItem');
                            $router->put('/cart/update',
                                '\QuadStudio\Service\Site\Http\Controllers\CartController@update')
                                ->name('updateCart');
                            $router->get('/cart/clear',
                                '\QuadStudio\Service\Site\Http\Controllers\CartController@clear')
                                ->name('clearCart');
                            //

                            $router->delete('/order-items/{item}',
                                '\QuadStudio\Service\Site\Http\Controllers\OrderItemController@destroy')
                                ->name('orders.items.destroy');

                        });
                    $router
                        ->group([
                            'middleware' => ['auth', 'admin'],
                            'namespace'  => 'Admin',
                            'prefix'     => 'admin',
                        ],
                            function () use ($router) {

                                // Панель управления
                                $router->name('admin')->get('/',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\IndexController@index');

                                // Авторизации
                                $router->name('admin')->resource('/authorization-brands',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationBrandController')
                                    ->except(['delete']);
                                $router->name('admin')->resource('/authorization-roles',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationRoleController')
                                    ->except(['delete', 'show', 'create']);
                                $router->name('admin')->get('/authorization-roles/create/{role}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationRoleController@create')
                                    ->name('.authorization-roles.create');
                                $router->name('admin')->resource('/authorization-types',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationTypeController')
                                    ->except(['delete']);
                                $router->name('admin')->resource('/authorizations',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationController')
                                    ->except(['delete']);
                                $router->name('admin')->resource('/mounters',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MounterController')
                                    ->except(['delete']);
                                $router->name('admin')->post('/authorizations/{authorization}/message',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AuthorizationController@message')
                                    ->name('.authorizations.message');

                                // Роуты
                                $router->name('admin')->get('routes',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\RouteController@index')
                                    ->name('.routes.index');

                                // Отчеты по монтажу
                                $router->name('admin')->resource('/mountings',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MountingController')
                                    ->only(['index', 'show', 'update']);

                                // Отчеты по ремонту
                                $router->name('admin')->resource('/repairs',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\RepairController')
                                    ->only(['index', 'show', 'update']);
                                $router->name('admin')->post('/repairs/{repair}/message',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\RepairController@message')
                                    ->name('.repairs.message');

                                // Бонусы за монтаж
                                $router->name('admin')->resource('/mounting-bonuses',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MountingBonusController')
                                    ->except(['show']);


                                // Банки
                                $router->name('admin')->resource('/banks',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\BankController');

                                // Органищации
                                $router->name('admin')->resource('/organizations',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\OrganizationController');

                                // Классы сложности
                                $router->name('admin')->put('/difficulties/sort',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DifficultyController@sort')
                                    ->name('.difficulties.sort');
                                $router->name('admin')->resource('/difficulties',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DifficultyController');

                                // Тарифы на транспорт
                                $router->name('admin')->put('/distances/sort',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DistanceController@sort')
                                    ->name('.distances.sort');
                                $router->name('admin')->resource('/distances',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DistanceController')->except(['show']);

                                // Акты
                                $router->name('admin')->resource('/acts',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ActController');
                                $router->name('admin')->get('/acts/{act}/schedule',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ActController@schedule')
                                    ->name('.acts.schedule');

                                // Сообщения
                                $router->name('admin')->resource('/messages',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MessageController')
                                    ->only(['index', 'show']);

                                // Инженеры
                                $router->name('admin')->resource('/engineers',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EngineerController')
                                    ->only(['index', 'edit', 'update']);

                                // Торговые организации
                                $router->name('admin')->resource('/trades',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\TradeController')
                                    ->only(['index', 'edit', 'update']);

                                // Ввод в эксплуатацию
                                $router->name('admin')->resource('/launches',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\LaunchController')
                                    ->only(['index', 'edit', 'update']);

                                // Контрагенты
                                $router->name('admin')->resource('/contragents',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ContragentController')
                                    ->except(['create', 'store', 'destroy']);

                                // Адреса контрагентов
                                $router->name('admin')->resource('/contragents/{contragent}/addresses',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ContragentAddressController')
                                    ->only(['edit', 'update'])
                                    ->names([
                                        'edit'   => 'admin.contragents.addresses.edit',
                                        'update' => 'admin.contragents.addresses.update',
                                    ]);

                                // Адреса
                                $router->name('admin')->resource('/addresses',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AddressController')
                                    ->except(['create', 'store']);

                                // Телефоны адреса
                                $router->name('admin')->resource('/addresses/{address}/phones',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AddressPhoneController')
                                    ->only(['create', 'store', 'edit', 'update', 'destroy'])
                                    ->names([
                                        'create'  => 'admin.addresses.phones.create',
                                        'store'   => 'admin.addresses.phones.store',
                                        'edit'    => 'admin.addresses.phones.edit',
                                        'update'  => 'admin.addresses.phones.update',
                                        'destroy' => 'admin.addresses.phones.destroy',
                                    ]);

                                // Зоны дистрибуции адреса
                                $router->name('admin')->resource('/addresses/{address}/regions',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AddressRegionController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.addresses.regions.index',
                                        'store' => 'admin.addresses.regions.store',
                                    ]);

                                // Пользователи
                                $router->name('admin')->resource('/users',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\UserController');
                                $router->name('admin')->get('/users/{user}/schedule',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\UserController@schedule')
                                    ->name('.users.schedule');
                                $router->name('admin')->get('/users/{user}/force',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\UserController@force')
                                    ->name('.users.force');

                                // Цены пользователя
                                $router->name('admin')->resource('/users/{user}/prices',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\UserPriceController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.users.prices.index',
                                        'store' => 'admin.users.prices.store',
                                    ]);

                                // Узлы схемы
                                $router->name('admin')->resource('/blocks',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\BlockController');

                                // Документация
                                $router->name('admin')->resource('/datasheets',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DatasheetController');

                                // Оборудование, к которому подходит документация
                                $router->resource('/datasheets/{datasheet}/products',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DatasheetProductController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.datasheets.products.index',
                                        'store' => 'admin.datasheets.products.store',
                                    ]);
                                $router->name('admin')->delete('/datasheets/{datasheet}/products/destroy',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\DatasheetProductController@destroy')
                                    ->name('.datasheets.products.destroy');

                                // Аналоги
                                $router->resource('/products/{product}/analogs',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductAnalogController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.products.analogs.index',
                                        'store' => 'admin.products.analogs.store',
                                    ]);
                                $router->name('admin')->delete('/products/{product}/analogs/destroy',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductAnalogController@destroy')
                                    ->name('.products.analogs.destroy');

                                // Детали
                                $router->resource('/products/{product}/details',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductDetailController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.products.details.index',
                                        'store' => 'admin.products.details.store',
                                    ]);
                                $router->name('admin')->delete('/products/{product}/details/destroy',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductDetailController@destroy')
                                    ->name('.products.details.destroy');

                                // Подходит к
                                $router->resource('/products/{product}/relations',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductRelationController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.products.relations.index',
                                        'store' => 'admin.products.relations.store',
                                    ]);
                                $router->name('admin')->delete('/products/{product}/relations/destroy',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductRelationController@destroy')
                                    ->name('.products.relations.destroy');

                                $router->name('admin')->put('/product-images/{product}/sort',
                                    'ProductImageController@sort')
                                    ->name('.products.images.sort');

                                // Каталог
                                $router->name('admin')->put('/catalogs/sort', function (Request $request) {
                                    Catalog::sort($request);
                                })->name('.catalogs.sort');
                                $router->name('admin')->resource('/catalogs',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CatalogController');
                                $router->name('admin')->get('/catalogs/create/{catalog?}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CatalogController@create')
                                    ->name('.catalogs.create.parent');
                                $router->name('admin')->get('/tree',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CatalogController@tree')
                                    ->name('.catalogs.tree');

                                // Товары
                                $router->name('admin')->resource('/products',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductController');

                                // Изображения товара
                                $router->resource('/products/{product}/images',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductImageController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.products.images.index',
                                        'store' => 'admin.products.images.store',
                                    ]);

                                // Оборудование
                                $router->name('admin')->resource('/equipments',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EquipmentController');
                                $router->name('admin')->get('/equipments/create/{catalog?}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EquipmentController@create')
                                    ->name('.equipments.create.parent');

                                $router->name('admin')->put('/equipments/sort', function (Request $request) {
                                    Equipment::sort($request);
                                })->name('.equipments.sort');

                                // Изображения оборудования
                                $router->resource('/equipments/{equipment}/images',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EquipmentImageController')
                                    ->only(['index', 'store'])
                                    ->names([
                                        'index' => 'admin.equipments.images.index',
                                        'store' => 'admin.equipments.images.store',
                                    ]);

                                // Изображения
                                $router->name('admin')->put('/images/sort', function (Request $request) {
                                    Image::sort($request);
                                })->name('.images.sort');

                                $router->name('admin')->resource('/images',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ImageController')
                                    ->only(['index', 'store', 'show', 'destroy']);

                                $router->name('admin')->resource('/files',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\FileController')
                                    ->only(['index', 'store', 'show', 'destroy']);

                                // Серийные номера
                                $router->name('admin')->resource('/serials',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SerialController')
                                    ->only(['index', 'show', 'create', 'store']);

                                // Сертификаты
                                $router->name('admin')->resource('/certificates',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CertificateController')
                                    ->only(['index', 'show']);
                                $router->name('admin')->get('/certificates/create/{certificate_type}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CertificateController@create')
                                    ->name('.certificates.create');
                                $router->name('admin')->post('/certificates/{certificate_type}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CertificateController@store')
                                    ->name('.certificates.store');

                                // Валюта
                                $router->name('admin')->resource('/currencies',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CurrencyController');
                                $router->name('admin')->resource('/currency_archives',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\CurrencyArchiveController')->only(['index']);

                                // Типы товаров
                                $router->name('admin')->resource('/product_types',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ProductTypeController');

                                // Типы цен
                                $router->name('admin')->resource('/price_types',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PriceTypeController')
                                    ->except(['create', 'store', 'destroy']);

                                // Типы файлов
                                $router->name('admin')->resource('/file_types',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\FileTypeController');

                                // Группы файлов
                                $router->name('admin')->resource('/file_groups',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\FileGroupController');

                                // Склады
                                $router->name('admin')->resource('/warehouses',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\WarehouseController');

                                // Страницы
                                $router->name('admin')->resource('/pages',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PageController');

                                //Контакты
                                $router->name('admin')->resource('/contacts',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ContactController');

                                // Телефоны
                                $router->name('admin')->resource('/phones',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PhoneController')
                                    ->except(['show']);

                                // Заказы
                                $router->name('admin')->resource('/orders',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\OrderController')
                                    ->only(['index', 'show', 'destroy']);
                                $router->name('admin')->post('/orders/{order}/message',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\OrderController@message')
                                    ->name('.orders.message');
                                $router->name('admin')->delete('/order-items/{item}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\OrderItemController@destroy')
                                    ->name('.orders.items.destroy');
                                $router->name('admin')->get('/orders/{order}/schedule',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\OrderController@schedule')
                                    ->name('.orders.schedule');

                                // Типы мероприятий
                                $router->name('admin')->put('/event_types/sort', function (Request $request) {
                                    EventType::sort($request);
                                })->name('.event_types.sort');
                                $router->name('admin')->resource('/event_types',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventTypeController');

                                // Мероприятия
                                $router->name('admin')->resource('/events',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventController');
                                $router->name('admin')->get('/events/{event}/mailing',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventController@mailing')
                                    ->name('.events.mailing');
                                $router->name('admin')->get('/events/{event}/attachment',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventController@attachment')
                                    ->name('.events.attachment');
                                $router->name('admin')->get('/events/create/{member?}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventController@create')
                                    ->name('.events.create');
                                $router->name('admin')->post('/events/store/{member?}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\EventController@store')
                                    ->name('.events.store');

                                $router->name('admin')->resource('/parts',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PartController')
                                    ->only(['edit', 'update', 'destroy']);


                                $router->name('admin')->resource('/members',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MemberController');

                                $router->name('admin')->resource('/elements',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ElementController');
                                $router->name('admin')->resource('/pointers',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PointerController');
                                $router->name('admin')->resource('/shapes',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ShapeController');

                                $router->name('admin')->resource('/templates',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\TemplateController');

                                $router->name('admin')->get('/participants/create/{member}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ParticipantController@create')
                                    ->name('.participants.create');
                                $router->name('admin')->post('/participants/store/{member}',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ParticipantController@store')
                                    ->name('.participants.store');
                                $router->name('admin')->resource('/participants',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\ParticipantController')
                                    ->only(['destroy']);

                                // Новости
                                $router->name('admin')->post('/announcements/image',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AnnouncementController@image')
                                    ->name('.announcements.image');
                                $router->name('admin')->resource('/announcements',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\AnnouncementController');

                                $router->name('admin')->post('/schemes/image',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@image')
                                    ->name('.schemes.image');
                                $router->name('admin')->get('/schemes/{scheme}/pointers',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@pointers')
                                    ->name('.schemes.pointers');
                                $router->name('admin')->get('/schemes/{scheme}/shapes',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@shapes')
                                    ->name('.schemes.shapes');
                                $router->name('admin')->get('/schemes/{scheme}/elements',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@elements')
                                    ->name('.schemes.elements');
                                $router->name('admin')->post('/schemes/{scheme}/elements',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@elements')
                                    ->name('.schemes.elements.update');
                                $router->name('admin')->delete('/schemes/{scheme}/elements',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController@elements')
                                    ->name('.schemes.elements.delete');
                                $router->name('admin')->resource('/schemes',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\SchemeController');

                                // Рассылка пользователям
                                $router->name('admin')->resource('/mailings',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\MailingController')
                                    ->only(['create', 'store']);

                                $router->name('admin')->resource('/prices',
                                    '\QuadStudio\Service\Site\Http\Controllers\Admin\PriceController');


//                                $router->group(['namespace' => 'User', 'prefix' => 'users/{user}'],
//                                    function () use ($router) {
//                                        $router->name('admin.users')->resource('/addresses',
//                                            'AddressController')
//                                            ->only(['index', 'create', 'store']);
//                                    });
//
                                $router->name('admin')->put('/blocks/sort', function (Request $request) {
                                    Block::sort($request);
                                })->name('.blocks.sort');


                                $router->name('admin')->put('/elements/sort', function (Request $request) {
                                    Element::sort($request);
                                })->name('.elements.sort');

                                $router->name('admin')->put('/file_types/sort', function (Request $request) {
                                    FileType::sort($request);
                                })->name('.file_types.sort');

                            });
                });


        $router->get('/register/confirm/{token}', 'Auth\RegisterController@confirm')->name('confirm');

        $router->group([
            'namespace' => 'Api',
            'prefix'    => 'api',
        ],
            function () use ($router) {

                // Товары для отчета по монтажу
                $router->name('api')->get('/products/mounting',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\ProductController@mounting');

                // Товары для отчета по ремонту
                $router->name('api')->get('/parts',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\PartController@index')
                    ->name('.parts.index');
                $router->name('api')->get('/parts/create/{product}',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\PartController@create')
                    ->name('.parts.create');


                // Сервисные центры на карте
                $router->name('api')->get('/services/{region?}',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\MapController@service_centers')
                    ->name('.service-centers');

                // Дилеры на карте
                $router->name('api')->get('/dealers/{region?}',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\MapController@where_to_buy')
                    ->name('.where-to-buy');

                // Монтажники на карте
                $router->name('api')->get('/mounters/{region?}',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\MapController@mounter_requests')
                    ->name('.mounter-requests');

                // Пользователи
                $router->name('api')->resource('/users',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\UserController')
                    ->only(['show']);

                // Заказы
                $router->name('api')->resource('/orders',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\OrderController')
                    ->only(['show']);

                // Акты выполненных работ
                $router->name('api')->resource('/acts',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\ActController')
                    ->only(['show']);

                // Быстрый заказ
                $router->get('/products/fast',
                    '\QuadStudio\Service\Site\Http\Controllers\Api\ProductController@fast')
                    ->name('api.products.fast');


                $router->name('api')->get('/products/analog', 'ProductController@analog');
                $router->name('api')->get('/products/product', 'ProductController@product');

                //$router->name('api')->get('/products/datasheet', 'ProductController@datasheet');


                $router->name('api')->get('/products/{product}', 'ProductController@show');
                //
                $router->name('api')->get('/boilers', 'BoilerController@index')->name('.boilers.search');
                $router->name('api')->get('/boilers/{product}', 'BoilerController@show')->name('.boilers.show');
            });


        $this->loadPackageRoutes();
    }

    private function loadPackageRoutes()
    {
        $routes = config('site.routes', []);
        foreach ($routes as $package) {
            $object = $this->app->make($package);
            if (is_object($object) && method_exists($object, 'routes')) {
                $object->routes();
            }
        }
    }

    /**
     * Отформатировать цену
     *
     * @param $price
     * @param Currency|null $currency
     * @return string
     */
    public function format($price, Currency $currency = null)
    {
        $result = [];

        $currency = is_null($currency) ? $this->currency() : $currency;

        if ($currency->symbol_left != '') {
            $result[] = $currency->symbol_left;
        }

        $result[] = number_format($this->cost($price, $currency), config('site.decimals', 0), config('site.decimalPoint', '.'), config('site.thousandSeparator', ' '));

        if ($currency->symbol_right != '') {
            $result[] = $currency->symbol_right;
        }

        return implode(' ', $result);
    }

    /**
     * @return Currency
     */
    public function currency()
    {
        return Auth::guest() ? Currency::find(config('site.defaults.currency')) : Auth::user()->currency;
    }

    public function cost($price, Currency $currency = null)
    {
        $currency = is_null($currency) ? $this->currency() : $currency;

        $price = $price * $currency->rates;

        if (($round = config('site.round', false)) !== false) {
            $price = round($price, $round);
        }

        if (($round_up = config('site.round_up', false)) !== false) {
            $price = ceil($price / (int)$round_up) * (int)$round_up;
        }

        return (float)$price;
    }

    /**
     * Округлить цену
     *
     * @param $price
     * @return float
     */
    public function round($price)
    {

        if (($round = config('site.round', false)) !== false) {
            $price = round($price, $round);
        }

        if (($round_up = config('site.round_up', false)) !== false) {
            $price = ceil($price / (int)$round_up) * (int)$round_up;
        }

        return $price;
    }

    /**
     * Проверить, является ли текущий пользователь администратором
     *
     * @return bool
     */
    public function isAdmin()
    {
        if ($user = $this->user()) {
            return $user->admin == 1;
        }

        return false;
    }

    /**
     * Получить текущего аутентифицированного пользователя
     *
     * @return \Illuminate\Foundation\Auth\User|null
     */
    public function user()
    {
        return $this->app->auth->user();
    }

}
