<?php

namespace QuadStudio\Service\Site;

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
     * Service Routes
     */
    public function routes()
    {

        ($router = $this->app->make('router'))
            ->group(['middleware' => ['online']],
                function () use ($router) {
                    $router->get('/', 'IndexController@index')->name('index');
                    $router->get('/services', 'ServiceController@index')->name('services');
                    $router->get('/products', 'ProductController@index')->name('products');
                    $router->get('/catalogs', 'CatalogController@index')->name('catalogs');
                    $router->get('/datasheets', 'DatasheetController@index')->name('datasheets');
                    $router->get('/abouts', 'StaticPageController@about')->name('abouts');
                    $router->get('/contacts', 'StaticPageController@contacts')->name('contacts');

                    $router->get('/currency/refresh/{id?}', function ($id = null, \QuadStudio\Service\Site\Contracts\Exchange $exchange) {
                        foreach (config('site.update', []) as $update_id) {
                            if (is_null($id) || $id == $update_id) {
                                $currency = \QuadStudio\Service\Site\Models\Currency::find($update_id);

                                $currency->fill($exchange->get($update_id));
                                $currency->save();
                            }

                        }
                    });

                    $router->group(['middleware' => ['auth']],
                        function () use ($router) {
                            $router->get('/home', 'HomeController@index')->name('home');
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
                                $router->name('admin')->resource('/equipments', 'EquipmentController');
                                $router->name('admin')->resource('/products', 'ProductController');
                                $router->name('admin')->resource('/product-types', 'ProductTypeController');
                                $router->name('admin')->resource('/prices', 'PriceController');
                                $router->name('admin')->resource('/price-types', 'PriceTypeController');
                                $router->name('admin')->resource('/engineers', 'EngineerController');
                                $router->name('admin')->resource('/trades', 'TradeController@index');
                                $router->name('admin')->resource('/launches', 'LaunchController@index');
                                $router->name('admin')->resource('/currencies', 'CurrencyController');
                                $router->name('admin')->resource('/banks', 'BankController');
                                $router->name('admin')->resource('/warehouses', 'WarehouseController');
                                $router->name('admin')->resource('/datasheets', 'DatasheetController');
                                $router->name('admin')->resource('/contragents', 'ContragentController');
                                $router->name('admin')->resource('/organizations', 'OrganizationController@index');

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

    /**
     * Получить текущего аутентифицированного пользователя
     *
     * @return \Illuminate\Foundation\Auth\User|null
     */
    public function user()
    {
        return $this->app->auth->user();
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

}