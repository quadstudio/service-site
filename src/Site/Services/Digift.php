<?php

namespace QuadStudio\Service\Site\Services;


use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use QuadStudio\Service\Site\Events\Digift\ExceptionEvent;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;

class Digift
{

	/**
	 * @var \GuzzleHttp\Client|null
	 */
	private $client;
	/**
	 * @var string|null
	 */
	private $platformToken;
	/**
	 * @var array
	 */
	private $params = [];
	/**
	 * @var array
	 */
	private $options = [];


	/**
	 * Digift constructor.
	 */
	public function __construct()
	{
		$this->platformToken = env('DIGIFT_TOKEN', null);
		$this->options = [
			'base_uri' => env('DIGIFT_URL', null),
			'timeout' => config('site.digift_timeout', 5.0),
			'headers' => [
				'Content-Type' => 'multipart/form-data',
			],
		];
	}

	/**
	 * Метод получения необходимой информации об участнике
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function profile(array $data)
	{

		$this->params = [
			'method' => 'GET',
			'uri' => 'auth/profile',
			'rules' => [
				'accessToken' => 'required|string',
			],
			'data' => [
				'key' => 'query',
				'value' => $data,
			],
		];

		return $this;
	}

	/**
	 * Получение токена участника для авторизации в ЛК
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function authorizeById(array $data)
	{

		$this->params = [
			'method' => 'GET',
			'uri' => 'auth/authorizeById',
			'rules' => [
				'id' => 'required|string|size:36',
			],
			'data' => [
				'key' => 'query',
				'value' => $data,
			],
		];

		return $this;
	}

	/**
	 * Метод для создания участника
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function createParticipant(array $data)
	{

		$this->params = [
			'method' => 'POST',
			'uri' => 'ampApi/createParticipant',
			'rules' => [
				'id' => 'required|string|size:36',
				'email' => 'required|string|email',
				'phone' => 'required|string|size:11',
				'balance' => 'required|numeric|min:0',
				'firstName' => 'required|string',
				'lastName' => 'nullable|string',
				'middleName' => 'nullable|string',
			],
			'data' => [
				'key' => 'form_params',
				'value' => $data,
			],

		];

		return $this;
	}

	/**
	 * Метод для изменения баланса
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function changeBalance(array $data)
	{
		$this->params = [
			'method' => 'POST',
			'uri' => 'ampApi/changeBalance',
			'rules' => [
				'id' => 'required|string|size:36',
				'operationType' => ['required', 'string', Rule::in(['increase', 'decrease'])],
				'operationValue' => 'required|numeric',
				'externalOperationId' => 'required|string|size:36',
			],
			'data' => [
				'key' => 'form_params',
				'value' => $data,
			]
		];

		return $this;
	}

	/**
	 * Метод для принудительной установки баланса
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function setBalance(array $data)
	{
		$this->params = [
			'method' => 'POST',
			'uri' => 'ampApi/setBalance',
			'rules' => [
				'id' => 'required|string|size:36',
				'balance' => 'required|numeric|min:0',
			],
			'data' => [
				'key' => 'form_params',
				'value' => $data,
			]
		];

		return $this;
	}

	/**
	 * Метод для отката изменений по балансу
	 *
	 * @param array $data
	 *
	 * @return Digift
	 */
	public function rollbackBalanceChange(array $data)
	{
		$this->params = [
			'method' => 'POST',
			'uri' => 'ampApi/rollbackBalanceChange',
			'rules' => [
				'externalOperationId' => 'required|string|size:36',
			],
			'data' => [
				'key' => 'form_params',
				'value' => $data,
			]
		];

		return $this;
	}

	/**
	 * @return bool|mixed
	 */
	public function json()
	{
		try {
			$response = $this->request();
			if ($response->getStatusCode() === Response::HTTP_OK) {
				$data = json_decode($response->getBody(), true);
				if ($data['code'] == 0) {
					return $data;
				}
				$this->logException($this->params['uri'], $data['message']);
			} else {
				$this->logException($this->params['uri'], $response->getReasonPhrase());
			}
		} catch (DigiftException $exception) {
			$this->logException($this->params['uri'], $exception->getMessage());
		} catch (GuzzleException $exception) {
			$this->logException($this->params['uri'], $exception->getMessage());
		}

		return false;
	}

	/**
	 * Отправить запрос
	 *
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 * @throws DigiftException
	 * @throws GuzzleException
	 */
	public function request()
	{
		$this->check();

		$this->client = new \GuzzleHttp\Client($this->options);

		return $this->client->request(
			$this->params['method'],
			$this->params['uri'],
			[
				$this->params['data']['key'] => array_merge(
					['platformToken' => $this->platformToken],
					$this->params['data']['value']
				),
			]
		);
	}

	/**
	 * @throws DigiftException
	 */
	private function check()
	{
		if (is_null($this->options['base_uri'])) {
			throw new DigiftException(trans('site::digift.exceptions.url_not_set'));
		}

		if (is_null($this->platformToken)) {
			throw new DigiftException(trans('site::digift.exceptions.token_not_set'));
		}

		if (!key_exists('method', $this->params)) {
			throw new DigiftException(trans('site::digift.exceptions.method_not_set'));
		}

		if (!key_exists('uri', $this->params)) {
			throw new DigiftException(trans('site::digift.exceptions.method_not_set'));
		}

		if (!isset($this->params['data']['value']) || !is_array($this->params['data']['value']) || empty($this->params['data']['value'])) {
			throw new DigiftException(trans('site::digift.exceptions.form_params_not_set'));
		}

		if (isset($this->params['rules']) && is_array($this->params['rules']) && !empty($this->params['rules'])) {

			$validator = Validator::make($this->params['data']['value'], $this->params['rules']);

			if ($validator->fails()) {
				throw new DigiftException(implode(', ', $validator->getMessageBag()->all()));
			}
		}
	}

	private function logException($method, $message)
	{
		event(new ExceptionEvent($method, $message));
	}
}