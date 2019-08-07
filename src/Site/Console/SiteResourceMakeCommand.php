<?php

namespace QuadStudio\Service\Site\Console;

use QuadStudio\Tools\Console\ToolsResourceMakeCommand;

class SiteResourceMakeCommand extends ToolsResourceMakeCommand
{

    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'site:resource';

    /**
     * The signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:resource
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold Service site views and routes';

    /**
     * @var array
     */
    protected $directories = [
        'resources/views/layouts',
    ];

    protected $controllers = [
        'api/RepairController.stub'               => 'Api/RepairController',
        'api/UserController.stub'                 => 'Api/UserController',
        'api/BoilerController.stub'               => 'Api/BoilerController',
        'api/OrderController.stub'                => 'Api/OrderController',
    ];

    /**
     * @var array
     */
    protected $assets = [
        'sass/_variables.scss',
        'sass/app.scss',
        'js/bootstrap.js',
        'js/app.js',
        'js/site.js',
        'js/parser.js',
        'js/router.js',
    ];

    protected $views = [
        'layouts/app.stub'   => 'layouts/app.blade.php',
        'layouts/email.stub' => 'layouts/email.blade.php',
    ];

    protected $seeds = [
        //'SiteSeeder.stub' => 'SiteSeeder',
    ];

    /**
     * @var array
     */
    protected $routes = [

    ];

    public function getAsset()
    {
        return __DIR__ . "/../../resources/assets/";
    }

    public function getStub()
    {
        return __DIR__ . "/stubs/";
    }

}