<?php

namespace QuadStudio\Service\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Models\Block;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Models\Currency;
use QuadStudio\Service\Site\Models\Element;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Pdf\ActPdf;
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
        if(is_null($date)){
            return $currency->getAttribute('rates');
        } else{
          if(($result = $currency->archives()->where('date', $date))->exists()){
              return $result->first()->getAttribute('rates');
          } else{
              return 0.00;
          }
        }
    }

    /**
     * Service Routes
     */
    public function routes()
    {

        ($router = $this->app->make('router'))
            ->group(['middleware' => ['online']],
                function () use ($router) {
                    $router->get('/', 'IndexController@index')->name('index');
                    $router->match(['get', 'post'],'/services', 'ServiceController@index')->name('services.index');
                    $router->match(['get', 'post'], '/dealers', 'DealerController@index')->name('dealers.index');

                    $router->get('/products/list', 'ProductController@list')->name('products.list');
                    $router->resource('/products', 'ProductController')->only(['index', 'show']);
                    $router->get('/products/{product}/schemes/{scheme}', 'ProductController@scheme')->name('products.scheme');
                    $router->resource('/catalogs', 'CatalogController')->only(['index', 'show']);
                    $router->get('/catalogs/{catalog}/list', 'CatalogController@list')->name('catalogs.list');
                    $router->resource('/equipments', 'EquipmentController')->only(['index', 'show']);
                    $router->resource('/datasheets', 'DatasheetController')->only(['index', 'show']);
                    $router->resource('/files', 'FileController')->only(['index', 'store', 'show', 'destroy']);
                    $router->get('/currencies/refresh/', 'CurrencyController@refresh')->name('currencies.refresh');
                    //$router->resource('/schemes', 'SchemeController')->only(['index','show']);

                    // Static pages
                    $router->get('/feedback', 'StaticPageController@feedback')->name('feedback');
                    $router->post('/feedback', 'StaticPageController@message')->name('message');
                    $router->get('/where-to-buy', 'StaticPageController@whereToBuy')->name('whereToBuy');

                    $router->group(['middleware' => ['auth']],
                        function () use ($router) {
                            $router->get('/home', 'HomeController@index')->name('home');
                            $router->post('/home/logo', 'HomeController@logo')->name('home.logo');
                            $router->resource('/acts', 'ActController')->middleware('permission:acts');
                            $router->get('/acts/{act}/pdf', function (Act $act) {
                                return (new ActPdf())->setModel($act)->render();
                            })->middleware('can:pdf,act')->name('acts.pdf');

                            $router->resource('/orders', 'OrderController')->except(['edit', 'update'])->middleware('permission:orders');
                            $router->post('/orders/{order}/message', 'OrderController@message')->middleware('permission:messages')->name('orders.message');
                            $router->delete('/order-items/{item}', 'OrderItemController@destroy')->name('orders.items.destroy');
                            $router->resource('/repairs', 'RepairController')->middleware('permission:repairs');
                            $router->post('/repairs/{repair}/message', 'RepairController@message')->middleware('permission:messages')->name('repairs.message');
                            $router->get('/repairs/{repair}/pdf', function (Repair $repair) {
                                return (new RepairPdf())->setModel($repair)->render();
                            })->middleware('can:pdf,repair')->name('repairs.pdf');

                            $router->resource('/engineers', 'EngineerController')->middleware('permission:engineers');
                            $router->resource('/trades', 'TradeController')->middleware('permission:trades');
                            $router->resource('/phones', 'PhoneController')->middleware('permission:phones')->except(['index', 'show']);
                            $router->resource('/launches', 'LaunchController')->middleware('permission:launches');
                            $router->resource('/contragents', 'ContragentController')->middleware('permission:contragents');
                            $router->resource('/contacts', 'ContactController')->middleware('permission:contacts');
                            $router->resource('/addresses', 'AddressController')->middleware('permission:addresses');
                            $router->get('/addresses/{address}/phone', 'AddressController@phone')->middleware('permission:addresses')->name('addresses.phone');
                            $router->post('/addresses/{address}/phone', 'AddressController@phone')->middleware('permission:addresses')->name('addresses.phone.store');
                            $router->resource('/messages', 'MessageController')->middleware('permission:messages');
                            // Cart
                            $router->get('/cart', 'CartController@index')->name('cart');
                            $router->post('/cart/{product}/add', 'CartController@add')->name('buy');
                            $router->delete('/cart/remove', 'CartController@remove')->name('removeCartItem');
                            $router->put('/cart/update', 'CartController@update')->name('updateCart');
                            $router->get('/cart/clear', 'CartController@clear')->name('clearCart');

                        });
//                    $router
//                        ->group([
//                            'middleware' => ['auth', 'admin'],
//                            'namespace'  => 'Admin\User',
//                            'prefix'     => 'admin/users/{user}',
//                        ],
//                            function () use ($router) {
//                                $router->name('admin.users')->resource('/addresses', 'AddressController');
//                            });
                    $router
                        ->group([
                            'middleware' => ['auth', 'admin'],
                            'namespace'  => 'Admin',
                            'prefix'     => 'admin',
                        ],
                            function () use ($router) {
                                $router->name('admin')->get('/', 'IndexController@index');
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
                                $router->name('admin')->resource('/users', 'UserController');
                                $router->name('admin')->get('/users/{user}/orders', 'UserController@orders')->name('.users.orders');


                                $router->name('admin')->get('/users/{user}/contragents', 'UserController@contragents')->name('.users.contragents');
                                $router->name('admin')->get('/users/{user}/contacts', 'UserController@contacts')->name('.users.contacts');
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
                                        $router->name('admin.addresses')->resource('/phones', 'PhoneController');//->only(['create', 'store'])
                                    });
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/orders', 'OrderController')->only(['index', 'show', 'destroy']);
                                $router->name('admin')->post('/orders/{order}/message', 'OrderController@message')->name('.orders.message');
                                $router->name('admin')->delete('/order-items/{item}', 'OrderItemController@destroy')->name('.orders.items.destroy');
                                $router->name('admin')->get('/orders/{order}/schedule', 'OrderController@schedule')->name('.orders.schedule');
                                $router->name('admin')->resource('/repairs', 'RepairController');
                                $router->name('admin')->post('/repairs/{repair}/message', 'RepairController@message')->name('.repairs.message');
                                $router->name('admin')->resource('/messages', 'MessageController');
                                $router->name('admin')->post('/repairs/{repair}/status', 'RepairController@status')->name('.repairs.status');
                                $router->name('admin')->resource('/serials', 'SerialController');
                                //$router->name('admin')->resource('/explodes', 'ExplodeController');
                                $router->name('admin')->put('/catalogs/sort', function (Request $request) {
                                    Catalog::sort($request);
                                })->name('.catalogs.sort');
                                $router->name('admin')->resource('/catalogs', 'CatalogController');
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
                $router->name('api')->get('/countries', 'CountryController@index')->name('.countries.index');
                $router->name('api')->get('/services/location', 'ServiceController@location')->name('.services.location');
                $router->name('api')->get('/services/{region?}', 'ServiceController@index')->name('.services.index');
                $router->name('api')->get('/dealers/{region?}', 'DealerController@index')->name('.dealers.index');

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