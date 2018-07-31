<?php

namespace QuadStudio\Service\Site\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class CurrentRouteViewComposer
{
    /**
     * @var Route
     */
    private $route;

    //TODO нужно разобраться с этой вакханалией, может через базу задавать или конфиг
    private $front_route = [
        'index',
        'login',
        'register',
        'contacts',
        'services',
        'datasheets',
        'catalogs',
        'products'
    ];

    /**
     * CurrentRouteViewComposer constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function compose(View $view)
    {
        $current_route = $this->route::currentRouteName();

        $view->with('current_route', $current_route ?? 'index');
        $view->with('current_menu', $this->current_menu());
        $view->with('current_body_class', $this->current_body_class());
    }

    /**
     * Получаем наименование шаблона меню по заданному роуту
     * @return string
     */
    private function current_menu()
    {
        $current_route = $this->route::currentRouteName();

        return isset($current_route) && in_array($current_route, config('site.front_routes', [])) ? 'front' : 'back';
    }

    /**
     * Получаем наименование класса для body по заданному роуту
     * @return string
     */
    private function current_body_class()
    {
        $current_route = $this->route::currentRouteName();

        return isset($current_route) && in_array($current_route, config('site.front_routes', [])) ? 'front-theme' : 'back-theme';
    }
}