<?php
return [
    'file'    => 'файл',
    'files'   => 'Файлы',
    'path'    => 'Путь к файлу',
    'storage' => 'Имя хранилища',
    'mime'    => 'Тип',
    'size'    => 'Размер',
    'name'    => 'Наименование',
    'error' => [
        'path' => 'Расширение файла должно быть: '.config('site.files.mime', 'jpg,jpeg,png,pdf')
    ]
];