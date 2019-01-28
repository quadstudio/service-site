<?php
return [
    'mailing'     => 'почтовую рассылку',
    'events'      => 'Почтовые рассылки',
    'icon'        => 'envelope',
    //
    'title'       => 'Заголовок',
    'content'     => 'Текст письма',
    'recipient'   => 'Получатели',
    'attachment'  => 'Файлы',

    //
    'created'     => 'Почтовая рассылка успешно разослана получателям',
    //
    'placeholder' => [
        'title'   => '',
        'content' => '',
    ],
    'error'       => [
        'attachment'       => [
            'required' => 'Файл не выбран или является порежденным',
            'mimes'    => 'Разрешено прикреплять только файлы: ' . config('site.mailing.mimes', 'jpg,jpeg,png,pdf'),
            'max'      => 'Максимально допустимый размер загружаемого файла: ' . formatBytes(config('site.mailing.attachment_max_size', 5000000)),
        ],
        'message_max_size' => 'Максимальный размер почтовойй рассылки: ' . formatBytes(config('site.mailing.message_max_size', 25000000))
    ],
    'header'      => [
        'recipients' => 'Получатели рассылки'
    ],
    'help'        => [
        'attachment' => 'Выбрать файлы',
    ]
];