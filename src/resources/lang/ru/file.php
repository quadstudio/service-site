<?php
return [
    'file'      => 'файл',
    'files'     => 'Файлы',
    'path'      => 'Имя файла',
    'storage'   => 'Путь',
    'mime'      => 'Расширение файла',
    'type_id'   => 'Тип файла',
    'size'      => 'Размер',
    'real_size' => 'Фактический размер',
    'name'      => 'Оригинальное имя файла',
    'downloads' => 'Количество скачиваний',
    'maxsize5mb' => 'Максимальный размер каждого файла 5 мегабайт',
    'error'     => [
        'path'      => 'Расширение файла должно быть: ' . config('site.files.mime', 'jpg,jpeg,png,pdf'),
        'max'       => 'Максимальный размер загружаемого файла должен быть не более: ' . config('site.files.size', 8092),
        'not_found' => 'Файл не найден',
    ]
];
