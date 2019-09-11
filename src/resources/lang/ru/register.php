<?php
return [
	'title' => 'Регистрация',
	'sc_address' => 'Фактический адрес',
	'sc_phone' => 'Телефон для обращения пользователей',
	'captcha' => 'Проверочный код с картинки',
	'legal' => 'Почтовый адрес совпадает с юридическим',
	'accept' => 'Я согласен с условиями использования сервисов и даю согласие на обработку своих персональных данных в соответствии с политикой компании',
	'header' => [
		"sc" => "Информация для конечных пользователей",
		"contragent" => "Информация об организации",
		"legal" => "Реквизиты организации",
		"payment" => "Платежные реквизиты",
	],
	'help' => [
		'sc' => 'Информация будет использоваться для отображения в списке сервисных центров',
		'mail' => 'Не получается зарегистрироваться? Отправьте нам Ваши данные на почту <a href="mailto:service@ferroli.ru">service@ferroli.ru</a> и мы поможем Вам.',
		'accept' => 'Условия использования',
	],
	'error' => [
		'captcha' => 'Неверный проверочный код с картинки',
	],
	'placeholder' => [
		'captcha' => 'Введите 4 цифры',
	],
	'password' => [
		'email' => [
			'title' => 'Сбросить пароль',
			'email' => 'E-mail',
			'send' => 'Отправить ссылку',
			'help' => [
				'email' => 'На указанный E-mail будет выслана ссылка для сброса пароля',
			],
		],
		'reset' => [
			'title' => 'Сбросить пароль',
			'email' => 'E-mail',
			'send' => 'Сбросить пароль',
			'password' => 'Новый пароль',
			"password_confirmation" => "Повторите пароль",
		],
		'hello' => 'Здравствуйте',
		'whoops' => 'Что-то пошло не так...',
		'regards' => 'С уважением',
		'trouble' => "Если у вас возникли проблемы с нажатием кнопки «:actionText», скопируйте и вставьте URL-адрес\n" .
			"в адресную строку в своем веб-браузере: [:actionURL](:actionURL)",
	],

];