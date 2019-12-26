<?php
return [
	'bonus' => 'Вознаграждение будет зачислено в течение :day дней.',
	'email' => [
		'exception' => [
			'title' => 'Ошибка при работе с Дигифт',
			'h1' => 'Ошибка при работе с Дигифт',
			'message' => 'При выполнении метода :method возникла следующая ошибка:',
		],
	],
	'exceptions' => [
		'url_not_set' => 'Не указан адрес web-сервиса Digift',
		'token_not_set' => 'Не указан токен сервиса Digift',
		'method_not_set' => 'Не указан метод для выполнения запроса',
		'form_params_not_set' => 'Не указаны данные для отправки',
		'form_params_is_invalid' => 'Данные для отправки содержат ошибки: :errors',
		'form_param_not_set' => 'Не указан :param',
		'contacts_not_exists' => 'Не указаны контакты пользователя',
		'phones_not_exists' => 'Не указаны телефоны пользователя',
		'form_param_required' => 'Параметр :param обязательный',
		'form_param_is_not_string' => 'Параметр :param должен быть строкой',
		'form_param_is_not_number' => 'Параметр :param должен быть числом',
		'form_param_is_not_in' => 'Параметр :param должен быть значением из :in',
	],
	'error' => [
		'admin' => [
			'unknown' => 'Произошла ошибка: :message',
			'guzzle' => 'Произошла ошибка при отправке HTTP запроса: :message',
			'digift' => 'Произошла ошибка Дигифт: :message',
		],
		'user' => [
			'unknown' => 'Произошла ошибка. Позвоните в службу поддержки',
			'guzzle' => 'Произошла ошибка при отправке HTTP запроса. Позвоните в службу поддержки',
			'digift' => 'Произошла ошибка Дигифт. Позвоните в службу поддержки',
		],
		'accessToken' => [
			'required' => 'Не указан access токен',
			'string' => 'Access токен должен быть строкой',
		],
	],

];