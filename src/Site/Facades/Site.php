<?php

namespace QuadStudio\Service\Site\Facades;

use Illuminate\Support\Facades\Facade;

class Site extends Facade
{
    /**
     * Register the routes for rbac management.
     *
     * @return void
     */
    public static function routes()
    {
        static::$app->make('site')->routes();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'site';
    }
}
