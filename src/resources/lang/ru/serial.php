<?php
return [
    'serial'      => 'Серийный номер',
    'serials'     => 'Серийные номера',
    'icon'        => 'barcode',
    //
    'loaded'      => 'Серийные номера успешно загружены',
    //
    'product_id'  => 'Оборудование',
    'comment'     => 'Комментарий к серийному номеру',
    //
    'placeholder' => [
        'load'           => 'Вставьте артикулы оборудования через разделитель и нажмите кнопку Загрузить',
        'search'         => 'Поиск серийного номера',
        'search_product' => 'Поиск оборудования'
    ],
    'error'       => [
        'not_found' => 'Не найден в базе',
        'not_exist' => 'Отсутствует',
        'load'      => [
            'file'              => 'Ошибка загрузки файла :error',
            'empty'             => 'Данные для загрузки отсутствуют',
            'product'           => 'Товар с артикулом :artikul не найден',
            'artikul_is_null'   => 'Артикул не указан',
            'artikul_not_found' => 'Артикул не найден',
            'serial_is_null'    => 'Серийный номер не указан',
            'duplicate'         => 'Найден дубликат артикула'
        ]
    ],
];