<?php

namespace QuadStudio\Service\Site;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use QuadStudio\Service\Site\Listeners\UserListener;
use QuadStudio\Service\Site\Middleware\Admin;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\User;

class SiteServiceProvider extends ServiceProvider
{

    protected $middleware = [
        'admin' => Admin::class,
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
            'users'       => User::class,
            'contragents' => Contragent::class,
            'equipments'  => Equipment::class,
            'products'    => Product::class,
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
        Event::subscribe(new UserListener());
    }


}