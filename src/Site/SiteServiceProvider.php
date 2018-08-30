<?php

namespace QuadStudio\Service\Site;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use QuadStudio\Service\Site\Http\ViewComposers\CurrentRouteViewComposer;
use QuadStudio\Service\Site\Listeners;
use QuadStudio\Service\Site\Middleware\Admin;
use QuadStudio\Service\Site\Support\Cart;

class SiteServiceProvider extends ServiceProvider
{

    protected $middleware = [
        'admin' => Admin::class,
    ];

    protected $policies = [
        Models\Trade::class      => Policies\TradePolicy::class,
        Models\Launch::class     => Policies\LaunchPolicy::class,
        Models\Engineer::class   => Policies\EngineerPolicy::class,
        Models\Repair::class     => Policies\RepairPolicy::class,
        Models\File::class       => Policies\FilePolicy::class,
        Models\Catalog::class    => Policies\CatalogPolicy::class,
        Models\Equipment::class  => Policies\EquipmentPolicy::class,
        Models\Image::class      => Policies\ImagePolicy::class,
        Models\Order::class      => Policies\OrderPolicy::class,
        Models\Product::class    => Policies\ProductPolicy::class,
        Models\Contact::class    => Policies\ContactPolicy::class,
        Models\Address::class    => Policies\AddressPolicy::class,
        Models\Contragent::class => Policies\ContragentPolicy::class,
        Models\User::class       => Policies\UserPolicy::class,
        Models\Act::class        => Policies\ActPolicy::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('site', function ($app) {
            return new Site($app);
        });
        $this->app->alias('site', Site::class);

        $this->app->bind('currency', function ($app) {
            return new Models\Currency($app);
        });

        $this->app->bind('cart', function ($app) {
            return new Cart($app, $app->make('session'));
        });

        $this->app->bind(Contracts\Exchange::class, function () {

            return new Exchanges\Cbr();
        });

        $this->loadConfig()->loadMigrations();
        $this->registerMiddleware();
    }

    /**
     * @return $this
     */
    private function loadMigrations()
    {
        $this->loadMigrationsFrom(
            $this->packagePath('database/migrations')
        );

        return $this;
    }

    /**
     * @param $path
     * @return string
     */
    private function packagePath($path)
    {
        return __DIR__ . "/../{$path}";
    }

    private function loadConfig()
    {
        $this->mergeConfigFrom(
            $this->packagePath('config/site.php'), 'site'
        );

        $this->mergeConfigFrom(
            $this->packagePath('config/cart.php'), 'cart'
        );

        return $this;
    }

    private function registerMiddleware()
    {
        if (!empty($this->middleware)) {

            /** @var \Illuminate\Routing\Router $router */
            $router = $this->app['router'];
            $registerMethod = false;

            if (method_exists($router, 'middleware')) {
                $registerMethod = 'middleware';
            } elseif (method_exists($router, 'aliasMiddleware')) {
                $registerMethod = 'aliasMiddleware';
            }

            if ($registerMethod !== false) {
                foreach ($this->middleware as $key => $class) {
                    $router->$registerMethod($key, $class);
                }
            }
        }

    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {

        $this
            ->publishAssets()
            ->publishTranslations()
            ->publishConfig()
            ->loadCommands();

        $this->loadMorphMap();
        $this->loadViews();
        $this->extendBlade();
        $this->registerEvents();
        $this->registerPolicies();

    }

    /**
     * @return $this
     */
    private function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\SiteRunCommand::class,
                Console\SiteSetupCommand::class,
                Console\SiteResourceMakeCommand::class,
            ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function publishConfig()
    {
        $this->publishes([
            $this->packagePath('config/site.php') => config_path('site.php'),
        ], 'config');

        $this->publishes([
            $this->packagePath('config/cart.php') => config_path('cart.php'),
        ], 'config');

        return $this;
    }

    private function publishTranslations()
    {

        $this->loadTranslations();

        $this->publishes([
            $this->packagePath('resources/lang') => resource_path('lang/vendor/site'),
        ], 'translations');

        return $this;
    }

    private function loadTranslations()
    {
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), 'site');
    }

    /**
     * Publish Portal assets
     *
     * @return $this
     */
    private function publishAssets()
    {

        $this->publishes([
            $this->packagePath('resources/assets') => resource_path('assets'),
        ], 'public');

        return $this;
    }

    /**
     * @return $this
     */
    private function loadMorphMap()
    {
        Relation::morphMap([
            'users'       => Models\User::class,
            'contragents' => Models\Contragent::class,
            'equipments'  => Models\Equipment::class,
            'products'    => Models\Product::class,
            'catalogs'    => Models\Catalog::class,
            'repairs'     => Models\Repair::class,
            'orders'      => Models\Order::class,
            'acts'        => Models\Act::class,
        ]);

        return $this;
    }

    /**
     * Publish Portal views
     *
     * @return $this
     */
    private function loadViews()
    {
        view()->composer("*", CurrentRouteViewComposer::class);

        $viewsPath = $this->packagePath('resources/views/');

        $this->loadViewsFrom($viewsPath, 'site');

        $this->publishes([
            $viewsPath => resource_path('views/vendor/site'),
        ], 'views');

        return $this;
    }

    private function extendBlade()
    {
        if (class_exists('\Blade')) {
            Blade::component('site::components.alert', 'alert');
            Blade::component('site::components.bool', 'bool');
            Blade::component('site::components.pagination', 'pagination');

            Blade::directive('admin', function () {
                return "<?php if (app('site')->isAdmin()) : ?>";
            });

            Blade::directive('elseadmin', function () {
                return "<?php else: // Site::admin ?>";
            });

            Blade::directive('endadmin', function () {
                return "<?php endif; // Site::admin ?>";
            });
        }
    }

    private function registerEvents()
    {
        Event::subscribe(new Listeners\UserListener());
        Event::subscribe(new Listeners\OrderListener());
        Event::subscribe(new Listeners\ActListener());
        Event::subscribe(new Listeners\RepairListener());
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }


}