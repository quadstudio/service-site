<?php
return [
    'seeders'  => [
        'countries',
        'regions',
        'contragent_types',
        'address_types',
        'contact_types',
        'product_types',
        'currencies',
        'users',
    ],
    'routes'   => [
        'rbac',
    ],
    'cache' => [
        'use' => false,
        'ttl' => 60 * 60 * 24
    ],
    'per_page' => [
        'repair'       => 2,
        'trade'        => 10,
        'launch'       => 10,
        'engineer'     => 10,
        'act'          => 10,
        'serial'       => 10,
        'period'       => 10,
        'order'        => 10,
        'product'      => 20,
        'product_type' => 20,
    ],
    'run'      => [
        ['site:resource', []],
        ['rbac:resource', []],
        ['migrate', []],
        ['db:seed', ['--class' => 'SiteSeeder']],
        ['db:seed', ['--class' => 'RbacSeeder']],
    ],
    'geocode'  => true,
    'files'    => [
        'mimes' => 'jpg,jpeg,png,pdf',
        'size'  => 8092,
        'path'  => date('Ym'),
        'image' => [
            'width' => 50
        ],
    ],
    'defaults' => [
        'admin' => [
            'price_type_id' => '08305aca-7303-11df-b338-0011955cba6b',
            'role_id'      => 1,
        ],
        'user' => [
            'warehouse_id' => '6f87e83f-722c-11df-b336-0011955cba6b',
            'price_type_id' => '08305aca-7303-11df-b338-0011955cba6b',
            'role_id'      => 2,
        ],

    ],

    'round' => false,

    'round_up' => false,

    'decimals' => 0,

    'decimalPoint' => '.',

    'thousandSeparator' => ' ',

    /*
    |--------------------------------------------------------------------------
    | Код основной валюта
    |--------------------------------------------------------------------------
    |
    | Для основной валюты устанавливается обменный курс = 1.0000
    |
    */
    'main'     => 643,

    /*
    |--------------------------------------------------------------------------
    | Коды обновляемых валют
    |--------------------------------------------------------------------------
    |
    | Для основной валюты устанавливается обменный курс = 1.0000
    |
    */
    'update'   => [
        840,
        933,
        978
    ],

    'exchange' => 'QuadStudio\Service\Site\Exchanges\Cbr'
];