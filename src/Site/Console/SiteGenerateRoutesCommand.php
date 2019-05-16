<?php

namespace QuadStudio\Service\Site\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Routing\Router;
use Illuminate\Console\Command;

class SiteGenerateRoutesCommand extends Command
{
    protected $signature = 'route:json';
    protected $description = 'Generate routes for javascript.';

    protected $router;

    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    public function handle()
    {
        $routes = [];

        foreach ($this->router->getRoutes() as $route) {
            $routes[$route->getName()] = $route->uri();
        }

        File::put('resources/assets/js/routes.json', json_encode($routes, JSON_PRETTY_PRINT));
    }
}