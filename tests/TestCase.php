<?php

namespace QuadStudio\Service\Test;

use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use QuadStudio\Online\OnlineServiceProvider;
use QuadStudio\Rbac\Facades\Rbac;
use QuadStudio\Rbac\RbacServiceProvider;
use QuadStudio\Repo\RepoServiceProvider;
use QuadStudio\Service\Site\Facades\Site;
use QuadStudio\Service\Site\SiteServiceProvider;

class TestCase extends OrchestraTestCase
{

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->withFactories(__DIR__.'../src/database/factories');
    }


    /**
     * Загружает сервис-провайдер пакета
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SiteServiceProvider::class,
        ];
    }

    /**
     * Возвращает псевдоним главного класса пакета
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Site' => Site::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.default', 'local');
        $app['config']->set('filesystems.disks', [
            'local' => [
                'driver' => 'local',
                'root'   => storage_path('app'),
            ],

            'public' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public'),
                'url'        => env('APP_URL') . '/storage',
                'visibility' => 'public',
            ],

            'repairs' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/repairs'),
                'url'        => env('APP_URL') . '/storage/repairs',
                'visibility' => 'public',
            ],

            'mountings' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/mountings'),
                'url'        => env('APP_URL') . '/storage/mountings',
                'visibility' => 'public',
            ],

            'equipments' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/equipments'),
                'url'        => env('APP_URL') . '/storage/equipments',
                'visibility' => 'public',
            ],

            'datasheets' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/datasheets'),
                'url'        => env('APP_URL') . '/storage/datasheets',
                'visibility' => 'public',
            ],

            'templates' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/templates'),
                'url'        => env('APP_URL') . '/storage/templates',
                'visibility' => 'public',
            ],

            'announcements' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/announcements'),
                'url'        => env('APP_URL') . '/storage/announcements',
                'visibility' => 'public',
            ],

            'events' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/events'),
                'url'        => env('APP_URL') . '/storage/events',
                'visibility' => 'public',
            ],

            'event_types' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/event_types'),
                'url'        => env('APP_URL') . '/storage/event_types',
                'visibility' => 'public',
            ],

            'schemes' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/schemes'),
                'url'        => env('APP_URL') . '/storage/schemes',
                'visibility' => 'public',
            ],

            'catalogs' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/catalogs'),
                'url'        => env('APP_URL') . '/storage/catalogs',
                'visibility' => 'public',
            ],

            'products' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/products'),
                'url'        => env('APP_URL') . '/storage/products',
                'visibility' => 'public',
            ],

            'logo' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/images/logo'),
                'url'        => env('APP_URL') . '/storage/images/logo',
                'visibility' => 'public',
            ],

            'mime' => [
                'driver'     => 'local',
                'root'       => storage_path('app/public/images/mime'),
                'url'        => env('APP_URL') . '/storage/images/mime',
                'visibility' => 'public',
            ],
        ]);
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => env('DB_PORT', '3306'),
            'database' => 'ferroli',
            'username' => 'root',
            'password' => '',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
//        $app['config']->set('database.default', 'testing');
//        $app['config']->set('database.connections.testing', [
//            'driver'   => 'sqlite',
//            'database' => ':memory:',
//            'prefix'   => '',
//        ]);
    }
}