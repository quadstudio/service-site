<?php
return [
    'mounting'        => 'отчет по монтажу',
    'mountings'       => 'Отчеты по монтажу',
    'icon'            => 'cogs',
    'created'         => 'Отчет по монтажу успешно создан',
    'updated'         => 'Отчет по монтажу успешно обновлен',
    'status_updated'  => 'Статус отчета по монтажу успешно обновлен',
    //
    'id'              => '№ отчета',
    'created_at'      => 'Дата создания',
    'user_id'         => 'Сервисный центр',
    'act_id'          => 'Включен в АВР',
    'status_id'       => 'Статус',
    'source_id'       => 'Откуда поступила заявка',
    'source_other'    => 'Иное',
    'serial_id'       => 'Серийный номер',
    'product_id'      => 'Оборудование',
    'contragent_id'   => 'Контрагент - исполнитель (Моё юридическое лицо или ИП)',
    'bonus'           => 'Премия за монтаж',
    'social_bonus'    => 'Премия за размещение в соц. сетях',
    'social_url'      => 'Ссылка на страницу в соц. сетях',
    'social_enabled'  => 'Учитывать премию за размещение в соцсетях',
    'date_trade'      => 'Дата продажи оборудования',
    'date_mounting'   => 'Дата монтажа',
    'engineer_id'     => 'Ответственный за монтаж',
    'trade_id'        => 'Торговая организация',
    'comment'         => 'Примечание',
    'country_id'      => 'Код страны',
    'address'         => 'Адрес установки оборудования',
    'client'          => 'ФИО',
    'phone_primary'   => 'Телефон',
    'phone_secondary' => 'Телефон (дополнительный)',
    'placeholder'     => [
        'serial_id'          => 'Находится на шильдике оборудования',
        'comment'            => '',
        'product_id'         => 'Введите артикул или наименование оборудования и выберите его из списка',
        'client'             => 'Например, Иванов Иван Иванович',
        'source_other'       => 'Например, По объявлению',
        'address'            => 'Например, Гагарин, ул. Пржевальского, 117',
        'social_url'         => 'Например в сети Instagram или Facebook',
        'phone_primary'      => 'Например, (925)123-45-67',
        'phone_secondary'    => 'Например, (925)123-45-67',
        'search_client'      => 'Поиск клиентов',
        'date_trade'         => 'Кликните для выбора даты',
        'date_mounting'      => 'Кликните для выбора даты',
        'date_mounting_from' => 'Дата монтажа С',
        'date_mounting_to'   => 'Дата монтажа По',
        'date_act_from'      => 'Дата АВР С',
        'date_act_to'        => 'Дата АВР По',
    ],
    'success'         => [
        'serial_find' => 'Серийный номер найден в базе данных',
    ],
    'header'          => [
        'mounting' => 'Отчет по монтажу',
        'client'   => 'Клиент (конечный пользователь оборудования)',
        'org'      => 'Информация о продавце оборудования',
        'call'     => 'Выезд на обслуживание',
        'extra'    => 'Дополнительная информация',
        'payment'  => 'Оплата',
        'files'    => 'Прикрепленные файлы',
    ],
    'validation'      => [
        'serial' => ':attribute не найден'
    ],
    'error'           => [
        'product_id' => 'Не участвует в программе'
    ],
    'help'            => [
        'serial_id'     => '<h5 class="text-danger">Внимание!</h5><p>Перед заполнением отчета по ремонту требуется проверить серийный номер оборудования на его наличие в нашей базе данных</p>',
        'total'         => 'Итого к оплате',
        'search_act'    => 'Поиск по серийному номеру',
        'search_client' => 'Поиск по ФИО клиента, телефону и адресу',
        'search_part'   => 'Поиск по артикулу и наименованию детали',
        'search_sc'     => 'Поиск по наименованию и E-mail СЦ',
        'last'          => 'Последний отчет',
        'not_found'     => 'Отчеты по ремонту не найдены',
        'button'        => 'Выберите файл и нажмите на кнопку &laquo;Загрузить&raquo;',
    ],
    'default'         => [
        'trade_id'    => '- Выбрать -',
        'engineer_id' => '- Выбрать -',
        'launch_id'   => '- Выбрать -',
    ],
    'email'           => [
        'create'        => [
            'title' => 'Создан новый отчет по монтажу',
            'h1'    => 'Создан новый отчет по монтажу',
        ],
        'status_change' => [
            'title' => 'Изменен статус отчета по монтажу',
            'h1'    => 'Изменен статус отчета по монтажу',
        ]

    ],
    'pdf'             => [
        'annex'         => 'Приложение № 2',
        'contract'      => 'К договору №',
        'city'          => 'Город',
        'organization'  => 'Наименование организации',
        'title'         => 'АКТ ВЫПОЛНЕНИЯ РАБОТ ПО МОНТАЖУ',
        'client'        => 'Потребитель (Ф.И.О.):',
        'phone'         => 'Телефон (с кодом):',
        'address'       => 'Адрес:',
        'model'         => 'Модель котла',
        'serial'        => 'Серийный номер',
        'date_trade'    => 'Дата продажи',
        'date_mounting' => 'Дата монтажа',
        'executor'      => 'Исполнитель',
        'fio'           => '(Ф.И.О.)',
        'sign'          => '(подпись)',
        'confirm'       => 'Подтверждаю замену указанных выше деталей, претензий к качеству работ не имею',
        'sign_client'   => '(подпись потребителя)',
        'cost'          => 'СТОИМОСТЬ ОКАЗАННЫХ УСЛУГ ПО МОНТАЖУ СОГЛАСНО ДОГОВОРА АВТОРИЗАЦИИ СЕРВИСНОГО ЦЕНТРА',
        'table'         => [
            'part'       => 'запасная часть',
            'difficulty' => 'выполненные работы',
            'distance'   => 'транспортные затраты',
            'pp'         => 'п/п',
            'sku'        => 'артикул',
            'cost'       => 'стоимость, руб',
            'category'   => 'категория',
            'total'      => 'ИТОГО',
            'rub'        => 'руб',
        ],
        'mp'            => 'М.П.',

    ],
    'excel'           => [
        "A1"  => "Номер строки",
        "B1"  => "АГР Статус",
        "C1"  => "АГР Номер",
        "D1"  => "АГР Дата создания",
        "E1"  => "АВР Номер",
        "F1"  => "Оригинал получен",
        "G1"  => "Контрагент Наименование",
        "H1"  => "Контрагент Город",
        "I1"  => "Дата ремонта",
        "J1"  => "Дата пуска",
        "K1"  => "Оборудование Серийный номер",
        "L1"  => "Обрудование наименование",
        "M1"  => "Артикул оборудования",
        "N1"  => "Расстояние",
        "O1"  => "Стоимость дороги",
        "P1"  => "Стоимость работ",
        "Q1"  => "Стоимость запчастей, руб",
        "R1"  => "Стоимость запчастей, евро",
        "S1"  => "Запчасти Артикул",
        "T1"  => "Запчасти Наименование",
        "U1"  => "Итого к оплате",
        "V1"  => "Клиент ФИО",
        "W1"  => "Адрес установки оборудования",
        "X1"  => "Код страны,Телефон",
        "Y1"  => "Торговая организация",
        "Z1"  => "Дата Продажи",
        "AA1" => "Ввод в эксплуатацию организация",
        "AB1" => "Ввод в эксплуатацию дата",
        "AC1" => "Дата вызова",
        "AD1" => "Причина вызова",
        "AE1" => "Результат диагностики",
        "AF1" => "Проведенные работы"
    ]

];
