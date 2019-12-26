<?php
return [
	'digift_expense' => 'Списание',
	'digift_expenses' => 'Списания',
	'icon' => 'gift',
	//
	'operationValue' => 'Сумма списания',
	'userDigiftId' => 'ID пользователя',
	'digiftOperationId' => 'ID операции',
	'email' => [
		'api' => [
			'h1' => 'Ошибка списания бонусов',
			'title' => 'Ошибка списания бонусов',
			'message' => 'При обращении к api для выполнении списания произошла следующая ошибка',
			'query_params' => 'Параметры запроса',
		],
	],
	'success' => [
		"code" => 0,
		"message" => "Успех",
		"result" => new \StdClass(),
	],
	'error' => [
		'data_not_valid' => [
			"code" => 7,
			"message" => "Данные не прошли валидацию",
			"result" => [],
		],
		'userDigiftId' => [
			'exists' => [
				"code" => 12,
				"message" => "Пользователя с таким ID не существует",
				"result" => [],
			],
		],
		'digiftOperationId' => [
			'unique' => [
				"code" => 10,
				"message" => "ID операции уже существует",
				"result" => [],
			],
		],
		'user_is_blocked' => [
			"code" => 20,
			"message" => "Пользователь заблокирован",
			"result" => [],
		],
	],
];