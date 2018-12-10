<?php
return [

    'seeders' => [
        'countries',
        'regions',
        'contragent_types',
        'address_types',
        'contact_types',
        'product_types',
        'currencies',
        'users',
    ],

    'front_routes' => [
        'index',
        'login',
        'register',
        'feedback',
        'services.index',
        'dealers.index',
        'addresses.eshop',
        'datasheets.index',
        'datasheets.show',
        'catalogs.index',
        'catalogs.show',
        'catalogs.list',
        'equipments.show',
        'products.index',
        'products.show',
        'schemes.show',
        'products.schemes',
        'products.scheme',
        'products.list',
        'whereToBuy',
        'cart',
        'password.reset',
        'password.request',
    ],
    'routes'       => [
        'rbac',
        'cart'
    ],

    'nds' => 18,

    'cache' => [
        'use' => false,
        'ttl' => 60 * 60 * 24
    ],

    'per_page' => [
        'user'         => 50,
        'block'        => 25,
        'catalog'      => 25,
        'repair'       => 50,
        'trade'        => 10,
        'launch'       => 10,
        'engineer'     => 10,
        'act'          => 10,
        'serial'       => 10,
        'period'       => 10,
        'order'        => 10,
        'product'      => 16,
        'archive'      => 21,
        'product_list' => 100,
        'product_type' => 25,
        'message'      => 30,
    ],

    'sort_order' => [
        'equipment' => 'sort_order',
        'catalog'   => 'sort_order',
    ],

    'datasheet' => [
        'products' => [
            'count' => 3
        ]
    ],

    'run'       => [
        ['site:resource', []],
        ['rbac:resource', []],
        ['migrate', []],
        ['db:seed', ['--class' => 'SiteSeeder']],
        ['db:seed', ['--class' => 'RbacSeeder']],
    ],
    'delimiter' => ':',

    'geocode' => true,

    'images' => [
        'mime' => 'jpg,jpeg,png',
        'size' => [
            'image'  => [
                'width'  => 500,
                'height' => 500
            ],
            'canvas' => [
                'width'  => 500,
                'height' => 500
            ],
        ],

    ],

    'schemes' => [
        'mime' => 'jpg,jpeg',
        'size' => [
            'image'  => [
                'width'  => 740,
                'height' => null
            ],
            'canvas' => [
                'width'  => 740,
                'height' => null
            ],
        ],

    ],

    'logo'                     => [
        'mime' => 'jpg,jpeg',
        'size' => [
            'image'  => [
                'width'  => 200,
                'height' => 200
            ],
            'canvas' => [
                'width'  => 200,
                'height' => 200
            ],
        ],

    ],
    'repair_status_transition' => [
        'admin' => [
            1 => [3, 4, 5, 6],
            2 => [3, 4, 5],
            3 => [],
            4 => [],
            5 => [],
            6 => [1],
        ],
        'user'  => [
            1 => [],
            2 => [],
            3 => [2],
            4 => [],
            5 => [],
            6 => [],
        ],

    ],

    'files' => [
        'mime' => 'jpg,jpeg,png,pdf',
        'size' => 8092,
        'path' => '',
        //'path' => date('Ym'),
    ],

    'defaults' => [
        'currency' => 643,
        'image'    => 'http://placehold.it/500x500',
        'guest'    => [
            'price_type_id' => '7fb003f2-aca8-11e8-80cc-85ebbdeccdc7',
        ],
        'admin'    => [
            'price_type_id' => '7fb003f2-aca8-11e8-80cc-85ebbdeccdc7',
            'role_id'       => 1,
        ],
        'user'     => [
            'warehouse_id'    => '19c8a7e7-8b9a-11e8-80c9-c659bc5ae479',
            'organization_id' => '728fcfa4-8b85-11e8-80c8-cd0a94fa06dd',
            'price_type_id'   => '7fb003f2-aca8-11e8-80cc-85ebbdeccdc7',
            'currency_id'     => 643,
            'role_id'         => 2,
        ],
        'part'     => [
            'price_type_id' => '7fb003f6-aca8-11e8-80cc-85ebbdeccdc7',
        ],

    ],

    'receiver_id' => 1,

    'round' => 0,

    'round_up' => false,

    'decimals' => 0,

    'decimalPoint' => '.',

    'thousandSeparator' => ' ',

    /*
    |--------------------------------------------------------------------------
    | Код основной валюты
    |--------------------------------------------------------------------------
    |
    | Для основной валюты устанавливается обменный курс = 1.0000
    |
    */
    'main'              => 643,

    'country' => 643,

    /*
    |--------------------------------------------------------------------------
    | Коды обновляемых валют
    |--------------------------------------------------------------------------
    |
    | Для основной валюты устанавливается обменный курс = 1.0000
    |
    */
    'update'  => [
        840,
        933,
        978
    ],

    'exchange' => 'QuadStudio\Service\Site\Exchanges\Cbr'
];
