<?php
return [
    'contragent'      => 'контрагента',
    'contragents'     => 'Контрагенты',
    'icon'            => 'users',
    //
    'name'            => 'Контрагент',
    "type_id"         => "Организационно-правовая форма",
    "organization_id" => "Заключен договор с",
    "guid"            => "Идентификатор 1С",
    'created_at'      => 'Дата регистрации',
    "inn"             => "ИНН",
    "ogrn"            => "ОГРН/ОГРНИП",
    "okpo"            => "ОКПО",
    "kpp"             => "КПП",
    "rs"              => "Расчётный счет",
    "ks"              => "Корреспондентский счет",
    "bik"             => "БИК",
    "bank"            => "Банк",
    "nds"             => "Работает с НДС?",
    //
    'created'         => 'Контрагент успешно создан',
    'updated'         => 'Контрагент успешно обновлен',
    'deleted'         => 'Контрагент успешно удален',
    //
    'header'          => [
        'contragent' => "Информация об организации",
        "legal"      => "Реквизиты организации",
        "payment"    => "Банковские реквизиты",
    ],
    'error'           => [
        'inn' => [
            'unique' => 'ИНН уже зарегистрирован. Проверьте введенные цифры, либо обратитесь к менеджеру'
        ],
    ],
    'placeholder'     => [
        'search'         => 'Поиск контрагентов...',
        "name"           => "Например, ООО Теплотехника",
        "legal_address"  => "Например, г Воронеж, ул Матросова, д 12",
        "postal_address" => "Например, г. Воронеж, а/я 101",
        "inn"            => "10 цифр для юр.лиц и 12 цифр для ИП",
        "ogrn"           => "13 цифр для юр.лиц или 15 цифр для ИП",
        "okpo"           => "8 или 10 цифр",
        "kpp"            => "9 цифр (обязательно для юр.лиц)",
        "rs"             => "20 цифр",
        "ks"             => "20 цифр",
        "bik"            => "9 или 11 цифр",
        "bank"           => "Например, ОАО АКБ Авангард",
    ],
    'help'            => [
        "name" => "Полное юридическое наименование в соответствии с учредительными документами",
    ],
];