<?php
return [
    'user'           => 'пользователя',
    'users'          => 'Пользователи',
    'icon'           => 'user',
    //
    "remember"       => "Запомнить меня",
    "forgot"         => "Я забыл свой пароль",
    "already"        => "Уже есть аккаунт?",
    "reset_link"     => "Отправить ссылку на сброс пароля",
    "reset_password" => "Сбросить пароль",
    'login'          => 'Вход в личный кабинет',
    'force_login'    => 'Войти как пользователь',
    'sign_in'        => 'Войти',
    'register'       => 'Регистрация сервисного центра',
    'sign_up'        => 'Регистрация',
    'logout'         => 'Выход',
    'sign_out'       => 'Выйти',
    //
    'created'        => 'Пользователь успешно создан',
    'updated'        => 'Пользователь обновлен',
    'deleted'        => 'Пользователь удален',
    //
    'name'           => 'Компания',
    'email'          => 'E-mail',
    'admin'          => 'Права администратора?',
    'logo'           => 'Логотип',
    'dealer'         => 'Не является сервисным центром',
    'dealer_comment' => '(Если "Да" - пользователь при регистрации указал, что он не является сервисным центром)',
    'verified'       => 'E-mail подтведжен?',
    'guid'           => 'Код 1С',
    'price_type_id'  => 'Тип цены',
    'currency_id'    => 'Валюта',
    'region_id'      => 'Основной регион',
    'type_id'        => 'Организационно-правовая форма',
    'warehouse_id'   => 'Склад',
    'active'         => 'Включен?',
    'display'        => 'Отображать?',
    'created_at'     => 'Дата регистрации',
    "logged_at"      => "Последний визит",
    "web"            => "Web-сайт",
    //
    'activeOn'       => 'Включен',
    'activeOff'      => 'Выключен',
    'verified_1'     => 'E-mail подтвержден ✔',
    'verified_0'     => 'E-mail не подтвержден ✖',
    'active_1'       => 'Включен ✔',
    'active_0'       => 'Заблокирован ✖',

    'verified_ico_1' => '✉',
    'verified_ico_0' => '✖',
    'active_ico_1'   => '✔',
    'active_ico_0'   => '✖',

    'asc_ico_1'      => '⚒',
    'asc_ico_0'      => '⚒',
    'csc_ico_1'      => '⚒⚒',
    'distr_ico_1'    => '🚚',
    'gendistr_ico_1' => '🚚',
    'dealer_ico_1'   => '$',
    'dealer_ico_0'   => '✖',
    'display_ico_1'  => '✔',
    'display_ico_0'  => '✖',

    'asc_1'                 => 'АСЦ ✔',
    'asc_0'                 => 'Не АСЦ ✖',
    'dealer_1'              => 'Дилер ✔',
    'dealer_0'              => 'Не дилер ✖',
    'display_1'             => 'Отображать на сайте ✔',
    'display_0'             => 'Не отображать на сайте ✖',
    'password'              => 'Пароль',
    "password_confirmation" => "Повторите пароль",
    "confirm_email"         => "Учетная запись создана!<br /><small>Для завершения регистрации вам необходимо подтвердить свой E-mail адрес. Пожалуйста, проверьте почтовый ящик <u>:email</u>, указанный при регистрации.</small>",
    "confirmed_email"       => "E-mail адрес подтвержден!",
    "confirm_title"         => "Подтвердите свой E-mail адрес",
    "confirm_h1"            => "Спасибо за регистрацию",
    "confirm_text"          => "Перейдите по <a href=':url'>ссылке</a> для подтверждения адреса.",
    "is_online"             => "Онлайн",
    "is_asc"                => "АСЦ?",
    "is_csc"                => "ДЗЧ?",
    "is_dealer"             => "Дилер?",
    "is_distr"              => "Дистр-р?",
    "is_gendistr"           => "ГенДистр?",
    "is_eshop"              => "ИМ?",
    "export"                => "Экпорт в 1С",
    "sort"                  => "Сортировка",
    //
    'success'               => [
        "export" => "Сервисный центр успешно экспортирован в 1С",
    ],
    'error'                 => [
        "export" => "Сервисный центр уже экспортирован в 1С",
        "guid"   => "Сервисный центр не был синронизирован с 1С"
    ],
    "header"                => [
        "contragent" => "Информация об организации",
        "info"       => "Данные для входа в личный кабинет",
        "login"      => "Вход в личный кабинет",
        "address"    => "Адрес сервисного центра",
        "contact"    => "Контактное лицо",
        "sc"         => "Наименование",
        "user"       => "Сервисный центр",
    ],
    "placeholder"           => [
        'name'                  => 'Например, СтройТехСервис ООО или Иванов Иван Иванович ИП',
        'email'                 => 'Например, service@center.ru',
        'password'              => 'От 6 до 20 символов',
        "password_confirmation" => "Чтобы не забыть ;)",
        'search'                => 'Поиск компании, e-mail',
        "web"                   => "Например, http://service.ru",
    ],
    "help"                  => [
        'dealer' => 'Я не являюсь сервисным центром',
        'name'   => 'Полное юридическое наименование в соответствии с учредительными документами',
        'email'  => 'Используется как логин для входа в личный кабинет',
        "web"    => "Адрес должен начинаться с http:// или https://",
        "back"   => "В карточку рользователя",
    ],
    'create'                => [
        'dealer'  => 'дилера',
        'display' => 'Отображать в списке дилеров?',
    ]
];
