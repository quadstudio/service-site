<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Shopping Cart config
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'instance' => 'cart',

    /*
    |--------------------------------------------------------------------------
    | Имя маршрута витрины магазина
    |--------------------------------------------------------------------------
    */

    'shop_route' => 'products.index',

    /*
    |--------------------------------------------------------------------------
    | Максимальное количество одного товара
    |--------------------------------------------------------------------------
    |
    | которое можно добавить в корзину
    |
    */

    'item_max_quantity' => 99,

    /*
    |--------------------------------------------------------------------------
    | Валюта цены товара
    |--------------------------------------------------------------------------
    |
    | Рубль - ₽
    | Евро - €
    | Доллар - $
    |
    */

    'currency' => true,

    'symbol_left' => '',

    'symbol_right' => '₽',

    'decimals' => 0,

    'decimalPoint' => '.',

    'thousandSeparator' => ' ',

    'checkout' => 'orders.store',

    'url' => true,

    'target' => '_self',

    'image' => true,

    'sku' => true,

    'availability' => true,

    'brand' => true,

    'unit'   => true,

    /*
    |--------------------------------------------------------------------------
    | Включить отображение массы товара в корзине
    |--------------------------------------------------------------------------
    |
    | Вес товара будет отображаться в выбранной единице массы weight_output
    |
    */
    'weight' => false,

    'weight_decimals' => 2,

    'weight_decimalPoint' => '.',

    'weight_thousandSeparator' => ' ',

    /**
     * g, kg, oz, lb
     */
    'weight_input'             => 'kg',

    'weight_output'     => 'kg',

    /*
    |--------------------------------------------------------------------------
    | Включить преобразование единиц массы
    |--------------------------------------------------------------------------
    |
    | Если выбрано значение true, то вес корзины будет пересчитан
    | из единциц weight_input в weight_output
    |
    */
    'weight_conversion' => true,

    /*
    |--------------------------------------------------------------------------
    | Единицы измерения массы
    |--------------------------------------------------------------------------
    |
    | грамм, килограмм, центнер, тонна
    |
    */
    'weight_units'      => [
        'g'  => 1,
        'kg' => 1000,
        'c'  => 100000,
        't'  => 1000000
    ],

];