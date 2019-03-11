<?php
return [
    'order'         => 'заказ',
    'orders'        => 'Заказы',
    //
    'icon'          => 'shopping-cart',
    'created'       => 'Заказ успешно создан',
    'updated'       => 'Заказ успешно обновлен',
    'loaded'        => 'Данные для заказа успешно загружены в корзину',
    //
    'id'            => '№ заказа',
    'status_id'     => 'Статус',
    'address_id'    => 'Склад отгрузки',
    'comment'       => 'Комментарий',
    'user_id'       => 'Сервисный центр',
    'contragent_id' => 'Контрагент',
    'created_at'    => 'Дата',
    'guid'          => 'Код 1С',

    'items'              => 'Содержимое заказа',
    'items_count'        => 'Товаров в заказе',
    'total'              => 'Итого к оплате',
    'client'             => 'Клиент',
    'total_short'        => 'К оплате',
    'info'               => 'Информация о заказе',
    'success'            => 'Заказ №:order успешно создан',
    'breadcrumb_index'   => 'Заказы',
    'breadcrumb_show'    => '№ :order от :date',
    'status_defaults'    => '- выбрать -',
    'date_defaults'      => '- выбрать -',
    'search_placeholder' => 'Поиск по товарам...',
    'placeholder'        => [
        'search_sc' => 'Поиск СЦ',
    ],
    'help'               => [
        'search_sc' => 'Поиск по наименованию и E-mail СЦ',
        'last'      => 'Последний заказ',
        'load'      => 'Выберите Excel файл и нажмите кнопку "Загрузить"'
    ],
    'email'              => [
        'user'  => [

        ],
        'admin' => [
            'title' => 'Новый заказ сервисного центра'
        ],
    ],
    'error'              => [
        'load' => [
            'file'                  => 'Ошибка загрузки файла :error',
            'empty'                 => 'Данные для загрузки отсутствуют',
            'product'               => 'Товар с артикулом :artikul не найден',
            'artikul_is_null'       => 'Артикул не указан',
            'artikul_not_found'     => 'Артикул не найден',
            'quantity_is_null'      => 'Количество не указано',
            'quantity_not_number'   => 'Количество должно быть числом',
            'quantity_not_integer'  => 'Количество должно быть целым числом',
            'quantity_not_positive' => 'Количество должно быть целым положительным числом',
            'quantity_max'          => 'Максимальное количество должно быть <= 99',
            'duplicate'             => 'Найден дубликат артикула'
        ]
    ]

];
