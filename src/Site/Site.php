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
     * Service Api Routes
     */
    public function apiRoutes()
    {
        ($router = $this->app->make('router'))
            ->group([
                'middleware' => ['auth:api'],
                'namespace'  => 'Api',
            ],
                function () use ($router) {

                });
    }


    /**
     * Service Web Routes
     */
    public function webRoutes()
    {

        ($router = $this->app->make('router'))
            ->group(['middleware' => ['online']],
                function () use ($router) {
                    $router->get('/', 'IndexController@index')->name('index');

                    $router->resource('/files',
                        '\QuadStudio\Service\Site\Http\Controllers\FileController')
                        ->only(['index', 'store', 'show', 'destroy']);

                    /* Интернет-магазины */
                    $router->get('/eshop', '\QuadStudio\Service\Site\Http\Controllers\AddressController@eshop')->name('addresses.eshop');


                    /* Новости */
                    $router->resource('/news', 'NewsController')->only(['index']);
                    /* Мероприятия */
                    $router->resource('/events', 'EventController')->only(['index', 'show']);
                    $router->resource('/events_fsf', 'EventFsfController')->only(['index', 'show']);
                    $router->resource('/events_fpf', 'EventFpfController')->only(['index', 'show']);
                    $router->resource('/events_fd', 'EventFdController')->only(['index', 'show']);
                    /* Заявки */
                    $router->get('/members/confirm/{token}', 'MemberController@confirm')->name('members.confirm');
                    $router->resource('/members', 'MemberController')->only(['index', 'create', 'store']);

                    /* Участники */
                    $router->resource('/participants', 'ParticipantController')->only(['create']);

                    $router->match(['get', 'post'], '/services', 'ServiceController@index')->name('services.index');
                    $router->match(['get', 'post'], '/dealers', 'DealerController@index')->name('dealers.index');

                    $router->get('/products/list', 'ProductController@list')->name('products.list');
                    $router->resource('/products', 'ProductController')->only(['index', 'show']);
                    $router->get('/products/{product}/schemes/{scheme}', 'ProductController@scheme')->name('products.scheme');
                    $router->resource('/catalogs', 'CatalogController')->only(['index', 'show']);
                    $router->get('/catalogs/{catalog}/list', 'CatalogController@list')->name('catalogs.list');
                    $router->resource('/equipments', 'EquipmentController')->only(['index', 'show']);
                    $router->resource('/datasheets', 'DatasheetController')->only(['index', 'show']);

                    $router->get('/currencies/refresh/', 'CurrencyController@refresh')->name('currencies.refresh');
                    //$router->resource('/schemes', 'SchemeController')->only(['index','show']);

                    // Static pages
                    $router->get('/feedback', 'StaticPageController@feedback')->name('feedback');
                    $router->post('/feedback', 'StaticPageController@message')->name('message');
                    $router->get('/where-to-buy', 'StaticPageController@whereToBuy')->name('whereToBuy');

                    $router->group(['middleware' => ['auth']],
                        function () use ($router) {
                            // Личный кабинет
                            $router->get('/home',
                                '\QuadStudio\Service\Site\Http\Controllers\HomeController@index')
                                ->name('home');
                            $router->post('/home/logo',
                                '\QuadStudio\Service\Site\Http\Controllers\HomeController@logo')
                                ->name('home.logo');

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
                            $router->get('/addresses/{address}/phone',
                                '\QuadStudio\Service\Site\Http\Controllers\AddressController@phone')
                                ->middleware('permission:addresses')
                                ->name('addresses.phone');
                            $router->post('/addresses/{address}/phone',
                                '\QuadStudio\Service\Site\Http\Controllers\AddressController@phone')
                                ->middleware('permission:addresses')
                                ->name('addresses.phone.store');

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
                            //
                            //
                            //
                            $router->resource('/acts', 'ActController')->middleware('permission:acts');
                            $router->get('/acts/{act}/pdf', function (Act $act) {
                                return (new ActPdf())->setModel($act)->render();
                            })->middleware('can:pdf,act')->name('acts.pdf');
                            $router->resource('/distributors', 'DistributorController')->only(['index', 'show'])->middleware('permission:distributors');
                            $router->get('/distributors/{order}/excel', function (Order $order) {
                                return (new OrderExcel())->setModel($order)->render();
                            })->middleware('can:distributor,order')->name('distributors.excel');
                            $router->post('/orders/load', 'OrderController@load')->middleware('permission:orders')->name('orders.load');
                            $router->resource('/orders', 'OrderController')->except(['edit', 'update'])->middleware('permission:orders');
                            $router->post('/orders/{order}/message', 'OrderController@message')->middleware('permission:messages')->name('orders.message');
                            $router->delete('/order-items/{item}', 'OrderItemController@destroy')->name('orders.items.destroy');
                            $router->resource('/phones', 'PhoneController')->middleware('permission:phones')->except(['index', 'show']);
                            $router->resource('/contragents', 'ContragentController')->middleware('permission:contragents');
                            $router->resource('/contacts', 'ContactController')->middleware('permission:contacts');
                            // Cart
                            $router->get('/cart', 'CartController@index')->name('cart');
                            $router->post('/cart/{product}/add', 'CartController@add')->name('buy');
                            $router->delete('/cart/remove', 'CartController@remove')->name('removeCartItem');
                            $router->put('/cart/update', 'CartController@update')->name('updateCart');
                            $router->get('/cart/clear', 'CartController@clear')->name('clearCart');
                            $router->get('/users/{user}/force', '\QuadStudio\Service\Site\Http\Controllers\HomeController@force')->name('users.admin');
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
                                //
                                //
                                //
                                $router->name('admin')->post('/news/image', 'NewsController@image')->name('.news.image');
                                $router->name('admin')->resource('/news', 'NewsController');
                                $router->name('admin')->resource('/mailings', 'MailingController')->only(['store']);
                                $router->name('admin')->resource('/templates', 'TemplateController');
                                $router->name('admin')->resource('/events', 'EventController');
                                $router->name('admin')->get('/events/{event}/mailing', 'EventController@mailing')->name('.events.mailing');
                                $router->name('admin')->get('/events/{event}/attachment', 'EventController@attachment')->name('.events.attachment');
                                $router->name('admin')->get('/events/create/{member?}', 'EventController@create')->name('.events.create');
                                $router->name('admin')->post('/events/store/{member?}', 'EventController@store')->name('.events.store');
                                $router->name('admin')->put('/event_types/sort', function (Request $request) {
                                    EventType::sort($request);
                                })->name('.event_types.sort');
                                $router->name('admin')->resource('/event_types', 'EventTypeController');
                                $router->name('admin')->resource('/members', 'MemberController');

                                $router->name('admin')->get('/participants/create/{member}', 'ParticipantController@create')->name('.participants.create');
                                $router->name('admin')->post('/participants/store/{member}', 'ParticipantController@store')->name('.participants.store');
                                $router->name('admin')->resource('/participants', 'ParticipantController')->only(['destroy']);
                                $router->name('admin')->post('/excel/repairs', 'ExcelController@repairs')->name('.excel.repairs');
                                $router->name('admin')->resource('/acts', 'ActController');
                                $router->name('admin')->get('/acts/{act}/schedule', 'ActController@schedule')->name('.acts.schedule');
                                $router->name('admin')->put('/blocks/sort', function (Request $request) {
                                    Block::sort($request);
                                })->name('.blocks.sort');
                                $router->name('admin')->resource('/blocks', 'BlockController');
                                $router->name('admin')->post('/schemes/image', 'SchemeController@image')->name('.schemes.image');
                                $router->name('admin')->get('/schemes/{scheme}/pointers', 'SchemeController@pointers')->name('.schemes.pointers');
                                $router->name('admin')->get('/schemes/{scheme}/shapes', 'SchemeController@shapes')->name('.schemes.shapes');
                                $router->name('admin')->get('/schemes/{scheme}/elements', 'SchemeController@elements')->name('.schemes.elements');
                                $router->name('admin')->post('/schemes/{scheme}/elements', 'SchemeController@elements')->name('.schemes.elements.update');
                                $router->name('admin')->delete('/schemes/{scheme}/elements', 'SchemeController@elements')->name('.schemes.elements.delete');
                                $router->name('admin')->resource('/schemes', 'SchemeController');
                                $router->name('admin')->put('/elements/sort', function (Request $request) {
                                    Element::sort($request);
                                })->name('.elements.sort');
                                $router->name('admin')->resource('/elements', 'ElementController');
                                $router->name('admin')->resource('/pointers', 'PointerController');
                                $router->name('admin')->resource('/shapes', 'ShapeController');

                                // Пользователи
                                $router->name('admin')->get('/users/mailing', 'UserController@mailing')->name('.users.mailing');
                                $router->name('admin')->resource('/users', 'UserController');
                                $router->name('admin')->get('/users/{user}/orders', 'UserController@orders')->name('.users.orders');
                                $router->name('admin')->get('/users/{user}/contragents', 'UserController@contragents')->name('.users.contragents');
                                $router->name('admin')->get('/users/{user}/contacts', 'UserController@contacts')->name('.users.contacts');
                                $router->name('admin')->get('/users/{user}/authorizations', 'UserController@authorizations')->name('.users.authorizations');
                                $router->name('admin')->get('/users/{user}/mountings', 'UserController@mountings')->name('.users.mountings');
                                $router->name('admin')->get('/users/{user}/repairs', 'UserController@repairs')->name('.users.repairs');
                                $router->name('admin')->get('/users/{user}/schedule', 'UserController@schedule')->name('.users.schedule');
                                $router->name('admin')->get('/users/{user}/prices', 'UserController@prices')->name('.users.prices');
                                $router->name('admin')->post('/users/{user}/prices', 'UserController@prices')->name('.users.prices.store');
                                $router->name('admin')->get('/users/{user}/force', 'UserController@force')->name('.users.force');

                                // Адреса
                                $router->name('admin')->resource('/addresses', 'AddressController')->except(['create', 'store']);

                                $router->group(['namespace' => 'User', 'prefix' => 'users/{user}'],
                                    function () use ($router) {
                                        $router->name('admin.users')->resource('/addresses', 'AddressController')->only(['index', 'create', 'store']);
                                    });
                                $router->group(['namespace' => 'Contragent', 'prefix' => 'contragents/{contragent}'],
                                    function () use ($router) {
                                        $router->name('admin.contragents')->resource('/addresses', 'AddressController')->only(['index', 'create', 'store']);
                                    });

                                $router->name('admin')->resource('/contacts', 'ContactController');
                                $router->name('admin')->resource('/phones', 'PhoneController')->except(['show']);

                                $router->group(['namespace' => 'Address', 'prefix' => 'addresses/{address}'],
                                    function () use ($router) {
                                        $router->name('admin.addresses')->resource('/phones', 'PhoneController');
                                        $router->name('admin.addresses')->resource('/regions', 'RegionController');
                                    });
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/orders', 'OrderController')->only(['index', 'show', 'destroy']);
                                $router->name('admin')->post('/orders/{order}/message', 'OrderController@message')->name('.orders.message');
                                $router->name('admin')->delete('/order-items/{item}', 'OrderItemController@destroy')->name('.orders.items.destroy');
                                $router->name('admin')->get('/orders/{order}/schedule', 'OrderController@schedule')->name('.orders.schedule');

                                $router->name('admin')->resource('/messages', 'MessageController');

                                $router->name('admin')->resource('/serials', 'SerialController');
                                //$router->name('admin')->resource('/explodes', 'ExplodeController');
                                $router->name('admin')->put('/catalogs/sort', function (Request $request) {
                                    Catalog::sort($request);
                                })->name('.catalogs.sort');
                                $router->name('admin')->resource('/catalogs', 'CatalogController');
                                $router->name('admin')->post('/images/field', 'ImageController@field')->name('.images.field');
                                $router->name('admin')->resource('/images', 'ImageController');
                                $router->name('admin')->get('/tree', 'CatalogController@tree')->name('.catalogs.tree');
                                $router->name('admin')->get('/catalogs/create/{catalog?}', 'CatalogController@create')->name('.catalogs.create.parent');
                                //
                                $router->name('admin')->put('/equipments/sort', function (Request $request) {

                                    Equipment::sort($request);
                                })->name('.equipments.sort');
                                $router->name('admin')->resource('/equipments', 'EquipmentController');

                                $router->name('admin')->get('/equipments/create/{catalog?}', 'EquipmentController@create')->name('.equipments.create.parent');

                                $router->name('admin')->post('/equipment-images/{equipment}/store', 'EquipmentImageController@store')->name('.equipments.images.store');
                                $router->name('admin')->get('/equipment-images/{equipment}/edit', 'EquipmentImageController@edit')->name('.equipments.images.edit');
                                $router->name('admin')->put('/equipment-images/{equipment}/update', 'EquipmentImageController@update')->name('.equipments.images.update');
                                $router->name('admin')->put('/equipment-images/{equipment}/sort', 'EquipmentImageController@sort')->name('.equipments.images.sort');
                                $router->name('admin')->delete('/equipment-images/{equipment}/destroy', 'EquipmentImageController@destroy')->name('.equipments.images.destroy');
                                //
                                $router->name('admin')->resource('/products', 'ProductController');
                                $router->name('admin')->get('/products/{product}/images', 'ProductController@images')->name('.products.images');
                                $router->name('admin')->post('/products/{product}/images', 'ProductController@images')->name('.products.images.update');
                                $router->name('admin')->get('/products/{product}/analogs', 'ProductController@analogs')->name('.products.analogs');
                                $router->name('admin')->post('/products/{product}/analogs', 'ProductController@analogs')->name('.products.analogs.update');
                                $router->name('admin')->get('/products/{product}/relations', 'ProductController@relations')->name('.products.relations');
                                $router->name('admin')->post('/products/{product}/relations', 'ProductController@relations')->name('.products.relations.update');
                                $router->name('admin')->get('/products/{product}/back_relations', 'ProductController@back_relations')->name('.products.back_relations');
                                $router->name('admin')->post('/products/{product}/back_relations', 'ProductController@back_relations')->name('.products.back_relations.update');
                                //$router->name('admin')->post('/product-images/{product}/store', 'ProductImageController@store')->name('.products.images.store');
                                $router->name('admin')->put('/product-images/{product}/sort', 'ProductImageController@sort')->name('.products.images.sort');
                                //
                                $router->name('admin')->post('/analogs/store/{product}', 'AnalogController@store')->name('.analogs.store');
                                $router->name('admin')->delete('/analogs/destroy/{product}/{analog}', 'AnalogController@destroy')->name('.analogs.destroy');
                                $router->name('admin')->post('/relations/store/{product}', 'RelationController@store')->name('.relations.store');
                                $router->name('admin')->delete('/relations/destroy/{product}/{relation}', 'RelationController@destroy')->name('.relations.destroy');
                                $router->name('admin')->resource('/product_types', 'ProductTypeController');
                                $router->name('admin')->put('/file_types/sort', function (Request $request) {
                                    FileType::sort($request);
                                })->name('.file_types.sort');
                                $router->name('admin')->resource('/file_types', 'FileTypeController');
                                $router->name('admin')->resource('/file_groups', 'FileGroupController');
                                $router->name('admin')->resource('/prices', 'PriceController');
                                $router->name('admin')->resource('/price_types', 'PriceTypeController')->except(['create', 'store', 'destroy']);
                                $router->name('admin')->resource('/engineers', 'EngineerController');
                                $router->name('admin')->resource('/trades', 'TradeController');
                                $router->name('admin')->resource('/launches', 'LaunchController');
                                $router->name('admin')->resource('/currencies', 'CurrencyController');
                                $router->name('admin')->resource('/pages', 'PageController');
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/parts', 'PartController')->only(['edit', 'update', 'destroy']);
                                $router->name('admin')->resource('/currency_archives', 'CurrencyArchiveController')->only(['index']);
                                $router->name('admin')->resource('/warehouses', 'WarehouseController');
                                $router->name('admin')->post('/datasheets/file', 'DatasheetController@file')->name('.datasheets.file');
                                $router->name('admin')->resource('/datasheets', 'DatasheetController');
                                $router->name('admin')->get('/datasheets/{datasheet}/products', 'DatasheetController@products')->name('.datasheets.products');
                                $router->name('admin')->post('/datasheets/{datasheet}/products', 'DatasheetController@products')->name('.datasheets.products.update');
                                $router->name('admin')->delete('/datasheets/{datasheet}/products', 'DatasheetController@products')->name('.datasheets.products.delete');
                                $router->name('admin')->resource('/contragents', 'ContragentController');
                                $router->name('admin')->resource('/organizations', 'OrganizationController');
                                $router->name('admin')->put('/difficulties/sort', 'DifficultyController@sort')->name('.difficulties.sort');
                                $router->name('admin')->resource('/difficulties', 'DifficultyController');
                                $router->name('admin')->put('/distances/sort', 'DistanceController@sort')->name('.distances.sort');
                                $router->name('admin')->resource('/distances', 'DistanceController')->except(['show']);

                            });
                });


        $router->get('/register/confirm/{token}', 'Auth\RegisterController@confirm')->name('confirm');

        $router->group([
            'namespace' => 'Api',
            'prefix'    => 'api',
        ],
            function () use ($router) {
                // Товары
                // Для отчета по монтажу
                $router->name('api')->get('/products/mounting', '\QuadStudio\Service\Site\Http\Controllers\Api\ProductController@mounting');
//                $router->name('api')->get('/countries', function (){
//                    return new CountryCollection(
//                        Country::query()->enabled()->orderBy('sort_order')->get()
//                    );
//                })->name('.countries.index');
                $router->name('api')->get('/services/location', 'ServiceController@location')->name('.services.location');
                $router->name('api')->get('/services/{region?}', 'ServiceController@index')->name('.services.index');
                $router->name('api')->get('/dealers/{region?}', 'DealerController@index')->name('.dealers.index');

                $router->name('api')->resource('/countries', 'CountryController')->only(['index']);
                $router->name('api')->resource('/users', 'UserController');
                $router->name('api')->resource('/orders', 'OrderController');
                $router->name('api')->resource('/acts', 'ActController');
                $router->name('api')->resource('/serials', 'SerialController');
                $router->name('api')->resource('/files', 'FileController')->only(['index', 'store', 'show', 'destroy'])->middleware('permission:files');
                $router->name('api')->resource('/contragents', 'ContragentController');
                $router->name('api')->get('/regions/{country}', 'RegionController@index')->name('.regions.index');
                //
                $router->name('api')->get('/products/repair', 'ProductController@repair');
                $router->name('api')->get('/products/analog', 'ProductController@analog');
                $router->name('api')->get('/products/product', 'ProductController@product');

                $router->name('api')->get('/products/datasheet', 'ProductController@datasheet');
                $router->name('api')->get('/products/fast', 'ProductController@fast');
                $router->name('api')->get('/products/{product}/part', 'ProductController@part');
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
