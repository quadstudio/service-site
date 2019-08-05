<?php
return [
    'repair'          => 'отчет по ремонту',
    'repairs'         => 'Отчеты по ремонту',
    'icon'            => 'wrench',
    'created'         => 'Отчет по ремонту успешно создан',
    'updated'         => 'Отчет по ремонту успешно обновлен',
    'status_updated'  => 'Статус отчета по ремонту успешно обновлен',
    //
    'id'              => '№ отчета',
    'user_id'         => 'Сервисный центр',
    'act_id'          => 'Включен в АВР',
    'status_id'       => 'Статус',
    'serial_id'       => 'Серийный номер',
    'product_id'      => 'Оборудование',
    'distance_id'     => 'Расстояние до объекта',
    'difficulty_id'   => 'Класс сложности работ',
    'contragent_id'   => 'Контрагент - исполнитель (Моё юридическое лицо или ИП)',
    'number'          => '№ акта гарантийного ремонта',
    'warranty_number' => '№ гарантийного талона',
    'warranty_period' => 'Гарантийный срок (месяцев)',
    'cost_distance'   => 'Стоимость дороги',
    'cost_difficulty' => 'Стоимость работ',
    'cost_parts'      => 'Стоимость деталей',
    'total_cost'      => 'Итого',
    'date_launch'     => 'Дата пуска оборудования',
    'date_trade'      => 'Дата продажи оборудования',
    'date_call'       => 'Дата вызова сервисного инженера',
    'date_repair'     => 'Дата ремонта',
    'engineer_id'     => 'Сервисный инженер',
    'trade_id'        => 'Торговая организация',
    'launch_id'       => 'Ввод в эксплуатацию',
    'reason_call'     => 'Причины вызова',
    'diagnostics'     => 'Результаты диагностики',
    'created_at'      => 'Дата создания',
    'works'           => 'Проведенные работы',
    'recommends'      => 'Рекоммендации инженера',
    'remarks'         => 'Замечания клиента',
    'country_id'      => 'Код страны',
    'address'         => 'Адрес установки оборудования',
    'client'          => 'ФИО',
    'phone_primary'   => 'Телефон',
    'file_1'          => 'Фото неисправных запчастей',
    'file_2'          => 'Корпус котла с шильдом',
    'file_3'          => 'Прочее',
    'phone_secondary' => 'Телефон (дополнительный)',
    'pressupbutton'   => 'и нажмите кнопку "Загрузить"',
    'accept'          => 'Получено согласие на обработку данных от клиента',
    //
    'received_1'      => 'Оригинал получен',
    'received_0'      => 'Оригинал не получен',
    'status_defaults' => '- выбрать -',
    'icons'           => [
        'road'  => 'car',
        'work'  => 'gavel',
        'parts' => 'cogs',
    ],
    //
    'placeholder'     => [
        'serial_id'         => 'Находится на шильдике оборудования',
        'product_id'        => 'Введите наименование или артикул оборудования и выберите его из списка',
        'number'            => 'Например, MZ033753',
        'warranty_number'   => 'Например, FC017402',
        'client'            => 'Например, Иванов Иван Иванович',
        'address'           => 'Например, Гагарин, ул. Пржевальского, 117',
        'phone_primary'     => 'Например, (925)123-45-67',
        'phone_secondary'   => 'Например, (925)123-45-67',
        'reason_call'       => 'Например, Треск в котле',
        'diagnostics'       => 'Например, Не исправен маностат',
        'works'             => 'Например, Замена маностата',
        'date_launch'       => 'Кликните для выбора даты',
        'date_trade'        => 'Кликните для выбора даты',
        'date_call'         => 'Кликните для выбора даты',
        'date_repair'       => 'Кликните для выбора даты',
        'search_part'       => 'Поиск деталей',
        'search_client'     => 'Поиск клиентов',
        'search_act'        => 'Поиск по номеру',
        'search_sc'         => 'Поиск СЦ',
        'search_contragent' => 'Поиск контрагента',
        'date_from'         => 'С...',
        'date_to'           => 'По...',
    ],
    'error'           => [
        'serial_find' => 'Серийный номер не найден в базе данных',
        'serial_id'   => 'Серийный номер не найден в базе данных',
    ],
    'success'         => [
        'serial_find' => 'Серийный номер найден в базе данных',
    ],
    'header'          => [
        'repair'  => 'Отчет по ремонту',
        'client'  => 'Клиент (конечный пользователь оборудования)',
        'org'     => 'Информация о продавце оборудования и вводе в эксплуатацию',
        'call'    => 'Выезд на обслуживание',
        'payment' => 'Оплата',
        'files'   => 'Прикрепленные файлы',
    ],
    'validation'      => [
        'serial' => ':attribute не найден',
    ],
    'help'            => [
        'has_serial'        => 'Серийный номер внесен',
        'is_found'          => 'Серийный номер найден в базе',
        'serial_id'         => '<h5 class="text-danger">Внимание!</h5><p>Перед заполнением отчета по ремонту требуется проверить серийный номер оборудования на его наличие в нашей базе данных</p>',
        'trade_id'          => 'Нет торговой организации в списке?',
        'engineer_id'       => 'Нет инженера в списке?',
        'launch_id'         => 'Нет ввода в экплуатацию в списке?',
        'product_select'    => 'Введите артикул или наименование запчасти',
        'date_act'          => 'Дата АВР',
        'cost_difficulty'   => 'Работа',
        'cost_distance'     => 'Дорога',
        'cost_parts'        => 'Детали',
        'total'             => 'Итого к оплате',
        'search_act'        => 'Поиск по серийному номеру',
        'search_client'     => 'Поиск по ФИО клиента, телефону и адресу',
        'search_part'       => 'Поиск по артикулу и наименованию детали',
        'search_sc'         => 'Поиск по наименованию и E-mail СЦ',
        'search_contragent' => 'Поиск по наименованию и ИНН контрагента',
        'last'              => 'Последний отчет',
        'not_found'         => 'Отчеты по ремонту не найдены',
    ],
    'default'         => [
        'trade_id'    => '- Выбрать -',
        'engineer_id' => '- Выбрать -',
        'launch_id'   => '- Выбрать -',
    ],

    'email' => [
        'create'        => [
            'title' => 'Создан новый отчет по ремонту',
            'h1'    => 'Создан новый отчет по ремонту',
        ],
        'status_change' => [
            'title' => 'Изменен статус отчета по ремонту',
            'h1'    => 'Изменен статус отчета по ремонту',
        ],
    ],

    'pdf'   => [
        'annex'        => 'Приложение № 2',
        'contract'     => 'К договору №',
        'city'         => 'Город',
        'organization' => 'Наименование организации',
        'title'        => 'АКТ ВЫПОЛНЕНИЯ РАБОТ ПО ГАРАНТИЙНОМУ РЕМОНТУ',
        'client'       => 'Потребитель (Ф.И.О.):',
        'phone'        => 'Телефон (с кодом):',
        'address'      => 'Адрес:',
        'model'        => 'Модель котла',
        'serial'       => 'Серийный номер',
        'date_trade'   => 'Дата продажи',
        'date_launch'  => 'Дата ввода в эксплуатацию',
        'date_call'    => 'Поступление заявки',
        'date_repair'  => 'Выполнение работ',
        'diagnostics'  => 'Описание неисправности и произведенных работ:',
        'works'        => 'Выполненные работы (с указанием артикула и наименования запчасти):',
        'executor'     => 'Исполнитель',
        'fio'          => '(Ф.И.О.)',
        'sign'         => '(подпись)',
        'confirm'      => 'Подтверждаю замену указанных выше деталей, претензий к качеству работ не имею',
        'sign_client'  => '(подпись потребителя)',
        'cost'         => 'СТОИМОСТЬ ОКАЗАННЫХ УСЛУГ ПО ГАРАНТИЙНОМУ РЕМОНТУ СОГЛАСНО ДОГОВОРА АВТОРИЗАЦИИ СЕРВИСНОГО ЦЕНТРА',
        'table'        => [
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
        'mp'           => 'М.П.',

    ],
    'excel' => [
        "A1"  => "Номер строки",
        "B1"  => "№ АВР",
        "C1"  => "Модель",
        "D1"  => "Серийный номер",
        "E1"  => "Дата продажи",
        "F1"  => "Дата пуска",
        "G1"  => "Адрес установки",
        "H1"  => "Имя клиента",
        "I1"  => "Телефон клиента",
        "J1"  => "Названия запчастей",
        "K1"  => "Стоимость з/ч EUR",
        "L1"  => "Арт. запчасти",
        "M1"  => "Стоимость работ, руб",
        "N1"  => "Стоимость дороги, руб",
        "O1"  => "Дата ремонта",
        "P1"  => "Общая стоимость, руб",
        "Q1"  => "Контрагент",
        "R1"  => "Город контрагента",
        "S1"  => "АГР №",
        "T1"  => "АГР дата",
        "U1"  => "АГР статус",
        "V1"  => "Оригинал АВР получен",
        "W1"  => "Арт. оборудования",
        "X1"  => "Дорога",
        "Y1"  => "Ст-ть з/ч, руб",
        "Z1"  => "Торговая орг-ия",
        "AA1" => "Ввод в эксплуатацию",
        "AB1" => "Причина вызова",
        "AC1" => "Результат диагностики",
        "AD1" => "Проведенные работы",


    ],


];
