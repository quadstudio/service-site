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
        'app/Http/Controllers/Admin',
        'app/Http/Controllers/Auth',
        'app/Http/Controllers/Api',
        'resources/views/layouts',
    ];

    protected $controllers = [
        'auth/ForgotPasswordController.stub' => 'Auth/ForgotPasswordController',
        'auth/LoginController.stub'          => 'Auth/LoginController',
        'auth/RegisterController.stub'       => 'Auth/RegisterController',
        'auth/ResetPasswordController.stub'  => 'Auth/ResetPasswordController',
        //
        'IndexController.stub'               => 'IndexController',
        'HomeController.stub'                => 'HomeController',
        'StaticPageController.stub'          => 'StaticPageController',
        'RepairController.stub'              => 'RepairController',
        'EngineerController.stub'            => 'EngineerController',
        'LaunchController.stub'              => 'LaunchController',
        'TradeController.stub'               => 'TradeController',
        'FileController.stub'                => 'FileController',
        'OrderController.stub'               => 'OrderController',
        'ProductController.stub'             => 'PartController',
        'ActController.stub'                 => 'ActController',
        'CostController.stub'                => 'CostController',
        'DatasheetController.stub'           => 'DatasheetController',
        'CatalogController.stub'             => 'CatalogController',
        'EquipmentController.stub'           => 'EquipmentController',
        'CartController.stub'                => 'CartController',
        'MessageController.stub'             => 'MessageController',
        'ContactController.stub'             => 'ContactController',
        'AddressController.stub'             => 'AddressController',
        'ContragentController.stub'          => 'ContragentController',
        //
        'api/FileController.stub'            => 'Api/FileController',
        'api/RepairController.stub'          => 'Api/RepairController',
        'api/CatalogController.stub'         => 'Api/CatalogController',
        'api/CountryController.stub'         => 'Api/CountryController',
        'api/RegionController.stub'          => 'Api/RegionController',
        'api/UserController.stub'            => 'Api/UserController',
        'api/SerialController.stub'          => 'Api/SerialController',
        'api/ServiceController.stub'         => 'Api/ServiceController',
        'api/ContragentController.stub'      => 'Api/ContragentController',
        'api/ProductController.stub'         => 'Api/ProductController',
        //
        'admin/WarehouseController.stub'     => 'Admin/WarehouseController',
        'admin/OrganizationController.stub'  => 'Admin/OrganizationController',
        'admin/CatalogController.stub'       => 'Admin/CatalogController',
        'admin/ImageController.stub'         => 'Admin/ImageController',
        'admin/DatasheetController.stub'     => 'Admin/DatasheetController',
        'admin/EngineerController.stub'      => 'Admin/EngineerController',
        'admin/TradeController.stub'         => 'Admin/TradeController',
        'admin/LaunchController.stub'        => 'Admin/LaunchController',
        'admin/SerialController.stub'        => 'Admin/SerialController',
        'admin/CurrencyController.stub'      => 'Admin/CurrencyController',
        'admin/RepairController.stub'        => 'Admin/RepairController',
        'admin/ActController.stub'           => 'Admin/ActController',
        'admin/IndexController.stub'         => 'Admin/IndexController',
        'admin/ContragentController.stub'    => 'Admin/ContragentController',
        'admin/UserController.stub'          => 'Admin/UserController',
        'admin/ServiceController.stub'       => 'Admin/ServiceController',
        'admin/OrderController.stub'         => 'Admin/OrderController',
        'admin/PriceController.stub'         => 'Admin/PriceController',
        'admin/PriceTypeController.stub'     => 'Admin/PriceTypeController',
        'admin/ProductController.stub'       => 'Admin/ProductController',
        'admin/ProductTypeController.stub'   => 'Admin/ProductTypeController',
        'admin/ContactController.stub'       => 'Admin/ContactController',
        'admin/AnalogController.stub'        => 'Admin/AnalogController',
        'admin/RelationController.stub'      => 'Admin/RelationController',
        'admin/ProductImageController.stub'  => 'Admin/ProductImageController',
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
    ];

    protected $views = [
        'layouts/app.stub' => 'layouts/app.blade.php',
    ];

    protected $seeds = [
        'SiteSeeder.stub' => 'SiteSeeder',
    ];

    /**
     * @var array
     */
    protected $routes = [
        'web.stub' => 0 //FILE_APPEND
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