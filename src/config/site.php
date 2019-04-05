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
        'service-centers',
        'where-to-buy',
        'online-stores',
        'news.index',
        'news.show',
        'events.index',
        'events.show',
        'events_fsf.index',
        'events_fsf.show',
        'members.index',
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
        'repair'       => 10,
        'mounting'     => 10,
        'trade'        => 10,
        'launch'       => 10,
        'engineer'     => 10,
        'act'          => 10,
        'serial'       => 10,
        'period'       => 10,
        'order'        => 10,
        'product'      => 28,
        'archive'      => 21,
        'product_list' => 100,
        'product_type' => 25,
        'message'      => 30,
        'news'         => 15,
    ],

    'per_page_range' => [
        'r8'  => [8 => 8, 32 => 32, 64 => 64, 128 => 128, 256 => 256, 512 => 512],
        'r10' => [10 => 10, 25 => 25, 50 => 50, 100 => 100, 250 => 250, 500 => 500],
    ],
    'sort_order'     => [
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

    'mailing' => [
        'mimes'               => 'jpg,jpeg,png,pdf',
        'message_max_size'    => 25000000,  // 25мб
        'attachment_max_size' => 5000000,   // 5мб
    ],

    'files' => [
        'mime' => 'jpg,jpeg,png,pdf',
        'size' => 128092,
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
        978
    ],

    'exchange' => 'QuadStudio\Service\Site\Exchanges\Cbr',

    'admin_ip' => [
        1 => '127.0.0.1'
    ],

    'name_limit'            => 25,

    /*
    |--------------------------------------------------------------------------
    | Телефоныый номер
    |--------------------------------------------------------------------------
    */
    'phone'                 => [

        // Правило для валидации формы
        'pattern'   => '^(\(([0-9]{3})\)\s([0-9]{3})-([0-9]{2})-([0-9]{2}))$',

        // Геттер (преобразование телефона из базы для отображения в форме)
        'get'       => [
            'pattern'     => '/^([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})$/',
            'replacement' => '($1) $2-$3-$4',
        ],

        // Сеттер (преобразование телефона из формы для сохранения в базе)
        'set'       => [
            'pattern'     => '/[^0-9]/',
            'replacement' => "",
        ],

        // Маска ввода для формы
        'mask'      => '(000) 000-00-00',

        // Формат, отображаемый при ошибке валидации в форме
        'format'    => '(XXX) XXX-XX-XX',

        // Длина номера телефона
        'maxlength' => 15
    ],
    'catalog_price_pdf'     => 'https://yadi.sk/d/7CXTYatd-Xp4bw',

    'storehouse_check' => [
        'gendistr',
        'csc'
    ]
];
