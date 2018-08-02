<?php
return [
    'file'    => 'файл',
    'files'   => 'Файлы',
    'path'    => 'Файл',
    'storage' => 'Имя хранилища',
    'mime'    => 'Тип',
    'size'    => 'Размер',
    'name'    => 'Наименование',
    'error' => [
        'path' => 'Расширение файла должно быть: '.config('site.files.mime', 'jpg,jpeg,png,pdf'),
        'max' => 'РМаксимальный размер загружаемого файла должен быть не более: '.config('site.files.size', 8092),
    ]
];