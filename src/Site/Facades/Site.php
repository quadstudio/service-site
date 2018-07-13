<?php

namespace QuadStudio\Service\Site\Facades;

/**
 * @method static float currencyRates(\QuadStudio\Service\Site\Models\Currency $cost_currency, \QuadStudio\Service\Site\Models\Currency $user_currency)
 *
 * @see \QuadStudio\Service\Site\Site
 */
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
