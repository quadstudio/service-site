<?php

namespace QuadStudio\Service\Site;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Models\Currency;

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
    public static function currencyRates(Models\Currency $cost_currency, Models\Currency $user_currency)
    {
        if ($cost_currency->getKey() == $user_currency->getKey()) {
            return 1;
        }
        if ($user_currency->getAttribute('rates') == 1) {
            return $cost_currency->getAttribute('rates');
        } else {
            return $user_currency->getAttribute('rates');
        }
    }

    /**
     * @return Currency
     */
    public function currency(){
        return Auth::guest() ? Currency::find(config('site.defaults.currency')) : Auth::user()->currency;
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
                    $router->get('/services', 'ServiceController@index')->name('services');
                    $router->resource('/products', 'ProductController')->only(['index', 'show']);
                    $router->resource('/catalogs', 'CatalogController')->only(['index', 'show']);
                    $router->resource('/equipments', 'EquipmentController')->only(['index', 'show']);
                    $router->get('/datasheets', 'DatasheetController@index')->name('datasheets');

                    // Static pages
                    $router->get('/abouts', 'StaticPageController@about')->name('abouts');
                    $router->get('/contacts', 'StaticPageController@contacts')->name('contacts');

                    $router->get('/currencies/refresh/{id?}', function ($id = null, \QuadStudio\Service\Site\Contracts\Exchange $exchange) {
                        foreach (config('site.update', []) as $update_id) {
                            if (is_null($id) || $id == $update_id) {
                                $currency = \QuadStudio\Service\Site\Models\Currency::find($update_id);

                                $currency->fill($exchange->get($update_id));
                                $currency->save();
                            }

                        }
                    })->name('currencies.refresh');

                    $router->group(['middleware' => ['auth']],
                        function () use ($router) {
                            $router->get('/home', 'HomeController@index')->name('home');
                            $router->resource('/acts', 'ActController')->middleware('permission:acts');
                            $router->resource('/orders', 'OrderController')->only(['index', 'show', 'store'])->middleware('permission:orders');
                            $router->resource('/repairs', 'RepairController')->middleware('permission:repairs');
                            $router->resource('/engineers', 'EngineerController')->middleware('permission:engineers');
                            $router->resource('/trades', 'TradeController')->middleware('permission:trades');
                            $router->resource('/files', 'FileController')->only(['index', 'store', 'show', 'destroy'])->middleware('permission:files');
                            $router->resource('/launches', 'LaunchController')->middleware('permission:launches');
                            $router->resource('/costs', 'CostController')->middleware('permission:costs');
                            $router->resource('/contragents', 'ContragentController')->middleware('permission:contragents');
                            // Cart
                            $router->get('/cart', 'CartController@index')->name('cart');
                            $router->post('/cart/add', 'CartController@add')->name('buy');
                            $router->delete('/cart/remove', 'CartController@remove')->name('removeCartItem');
                            $router->put('/cart/update', 'CartController@update')->name('updateCart');
                            $router->get('/cart/clear', 'CartController@clear')->name('clearCart');

                        });

                    $router
                        ->group([
                            'middleware' => ['auth', 'admin'],
                            'namespace'  => 'Admin',
                            'prefix'     => 'admin',
                        ],
                            function () use ($router) {
                                $router->name('admin')->get('/', 'IndexController@index');
                                $router->name('admin')->resource('/acts', 'ActController');
                                $router->name('admin')->resource('/users', 'UserController');
                                $router->name('admin')->get('/users/export/{user?}', 'UserController@export')->name('.users.export');
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/orders', 'OrderController')->only(['index', 'show']);
                                $router->name('admin')->resource('/repairs', 'RepairController');
                                $router->name('admin')->resource('/serials', 'SerialController');
                                $router->name('admin')->resource('/catalogs', 'CatalogController');
                                $router->name('admin')->get('/tree', 'CatalogController@tree')->name('.catalogs.tree');
                                $router->name('admin')->get('/catalogs/create/{catalog?}', 'CatalogController@create')->name('.catalogs.create.parent');
                                $router->name('admin')->resource('/equipments', 'EquipmentController');
                                $router->name('admin')->get('/equipments/create/{catalog?}', 'EquipmentController@create')->name('.equipments.create.parent');
                                $router->name('admin')->resource('/images', 'ImageController');
                                $router->name('admin')->resource('/products', 'ProductController');
                                $router->name('admin')->resource('/product-types', 'ProductTypeController');
                                $router->name('admin')->resource('/prices', 'PriceController');
                                $router->name('admin')->resource('/price-types', 'PriceTypeController');
                                $router->name('admin')->resource('/engineers', 'EngineerController');
                                $router->name('admin')->resource('/trades', 'TradeController');
                                $router->name('admin')->resource('/launches', 'LaunchController');
                                $router->name('admin')->resource('/currencies', 'CurrencyController');
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/warehouses', 'WarehouseController');
                                $router->name('admin')->resource('/datasheets', 'DatasheetController');
                                $router->name('admin')->resource('/contragents', 'ContragentController');
                                $router->name('admin')->resource('/organizations', 'OrganizationController');

                            });
                });


        $router->get('/register/confirm/{token}', 'Auth\RegisterController@confirm')->name('confirm');

        $router->group([
            'namespace' => 'Api',
            'prefix'    => 'api',
        ],
            function () use ($router) {
                $router->name('api')->get('/countries', 'CountryController@index')->name('.countries.index');
                $router->name('api')->resource('/users', 'UserController');
                $router->name('api')->resource('/serials', 'SerialController');
                $router->name('api')->resource('/parts', 'PartController');
                $router->name('api')->resource('/files', 'FileController')->only(['index', 'store', 'show', 'destroy'])->middleware('permission:files');
                $router->name('api')->resource('/contragents', 'ContragentController');
                $router->name('api')->get('/regions/{country}', 'RegionController@index')->name('.regions.index');

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

    public function cost($price)
    {

        $price = $price * $this->user()->currency->rates;

        if (($round = config('site.round', false)) !== false) {
            $price = round($price, $round);
        }

        if (($round_up = config('site.round_up', false)) !== false) {
            $price = ceil($price / (int)$round_up) * (int)$round_up;
        }

        return (float)$price;
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