<?php
return [
    'repair'          => 'отчет по ремонту',
    'repairs'         => 'Отчеты по ремонту',
    'icon'            => 'wrench',
    'created'         => 'Отчет по ремонту успешно добавлен',
    'updated'         => 'Отчет по ремонту успешно обновлен',
    'status_updated'  => 'Статус отчета по ремонту успешно обновлен',
    //
    'user_id'         => 'Сервисный центр',
    'status_id'       => 'Статус',
    'serial_id'       => 'Серийный номер',
    'number'          => '№ акта гарантийного ремонта',
    'warranty_number' => '№ гарантийного талона',
    'warranty_period' => 'Гарантийный срок (месяцев)',
    'cost_work'       => 'Стоимость работ',
    'cost_road'       => 'Стоимость дороги',
    'cost_parts'      => 'Стоимость деталей',
    'allow_work'      => 'Учитывать стоимость работ',
    'allow_road'      => 'Учитывать стоимость дороги',
    'allow_parts'     => 'Учитывать стоимость замененных деталей',
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
    'file_1'          => 'Гарантийный талон',
    'file_2'          => 'Корпус котла с шильдом',
    'file_3'          => 'Прочее',
    'phone_secondary' => 'Телефон (дополнительный)',
    //
    'status_defaults' => '- выбрать -',
    //
    'placeholder'     => [
        'serial_id'       => 'Серийный номер',
        'number'          => 'Например, MZ033753',
        'warranty_number' => 'Например, FC017402',
        'client'          => 'Например, Иванов Иван Иванович',
        'address'         => 'Например, Гагарин, ул. Пржевальского, 117',
        'phone_primary'   => 'Например, 9251234567',
        'phone_secondary' => 'Например, 9251234567',
        'reason_call'     => 'Например, Треск в котле',
        'diagnostics'     => 'Например, Не исправен маностат',
        'works'           => 'Например, Замена маностата',
        'date_launch'     => 'Укажите дату',
        'date_trade'      => 'Укажите дату',
        'date_call'       => 'Укажите дату',
        'date_repair'     => 'Укажите дату',
        'search_part'     => 'Поиск деталей',
        'search_client'   => 'Поиск клиентов',
        'search_act'      => 'Поиск по номеру',
        'search_sc'       => 'Поиск СЦ',
    ],
    'error'           => [
        'serial_find' => 'Серийный номер не найден в базе данных',
        'serial_id'   => 'Серийный номер не найден в базе данных',
    ],
    'success'         => [
        'serial_find' => 'Серийный номер найден в базе данных',
    ],
    'header'          => [
        'repair'  => 'Акт гарантийного ремонта',
        'client'  => 'Клиент',
        'org'     => 'Организации',
        'call'    => 'Выезд на обслуживание',
        'payment' => 'Оплата',
    ],
    'validation'      => [
        'serial' => ':attribute не найден'
    ],
    'help'            => [
        'serial_id'      => '<h5 class="text-danger">Внимание!</h5><p>Перед заполнением отчета по ремонту требуется проверить серийный номер оборудования на его наличие в нашей базе данных</p>',
        'trade_id'       => 'Нет торговой организации в списке?',
        'engineer_id'    => 'Нет инженера в списке?',
        'launch_id'      => 'Нет ввода в экплуатацию в списке?',
        'product_select' => 'Введите артикул или наименование запчасти',
        'cost_work'      => 'Работа',
        'cost_road'      => 'Дорога',
        'cost_parts'     => 'Детали',
        'search_act'     => 'Поиск по серийному номеру, номеру отчета и номеру гарантйиного ремонта',
        'search_client'  => 'Поиск по ФИО клиента, телефону и адресу',
        'search_part'    => 'Поиск по артикулу и наименованию детали',
        'search_sc'      => 'Поиск по наименованию и E-mail СЦ',
        'last'           => 'Последний отчет',
    ],
    'default'         => [
        'trade_id'    => '- Выбрать -',
        'engineer_id' => '- Выбрать -',
        'launch_id'   => '- Выбрать -',
    ],


];