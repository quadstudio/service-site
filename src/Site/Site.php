<?php

namespace QuadStudio\Service\Site;


use Illuminate\Support\Facades\Auth;

use QuadStudio\Service\Site\Models\Currency;


class Site
{

	/**
	 * Laravel application
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	public $app;

	/**
	 * Lock constructor.
	 *
	 * @param $app
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * @param Models\Currency $cost_currency
	 * @param Models\Currency $user_currency
	 * @param null $date
	 *
	 * @return float
	 */
	public static function currencyRates(Models\Currency $cost_currency, Models\Currency $user_currency, $date = null)
	{
		if ($cost_currency->getKey() == $user_currency->getKey()) {
			return 1;
		}
		$currency = ($user_currency->getAttribute('rates') == 1) ? $cost_currency : $user_currency;

//        if ($user_currency->getAttribute('rates') == 1) {
//            return $cost_currency->getAttribute('rates');
//        } else {
//            return $user_currency->getAttribute('rates');
//        }
		if (is_null($date)) {
			return $currency->getAttribute('rates');
		} else {
			if (($result = $currency->archives()->where('date', $date))->exists()) {
				return $result->first()->getAttribute('rates');
			} else {
				return 0.00;
			}
		}
	}

	/**
	 * Service Web Routes
	 */
	public function routes()
	{

		$routes = config('site.routes', []);
		foreach ($routes as $package) {
			$object = $this->app->make($package);
			if (is_object($object) && method_exists($object, 'routes')) {
				$object->routes();
			}
		}
	}


	/**
	 * Отформатировать цену
	 *
	 * @param $price
	 * @param Currency|null $currency
	 *
	 * @return string
	 */
	public function format($price, Currency $currency = null)
	{
		$result = [];

		$currency = is_null($currency) ? $this->currency() : $currency;

		if ($currency->symbol_left != '') {
			$result[] = $currency->symbol_left;
		}

		$result[] = number_format($this->cost($price, $currency), config('site.decimals', 0), config('site.decimalPoint', '.'), config('site.thousandSeparator', ' '));

		if ($currency->symbol_right != '') {
			$result[] = $currency->symbol_right;
		}

		return implode(' ', $result);
	}

	/**
	 * @return Currency
	 */
	public function currency()
	{
		return Auth::guest() ? Currency::find(config('site.defaults.currency')) : Auth::user()->currency;
	}

	public function cost($price, Currency $currency = null)
	{
		$currency = is_null($currency) ? $this->currency() : $currency;

		$price = $price * $currency->rates;

		if (($round = config('site.round', false)) !== false) {
			$price = round($price, $round);
		}

		if (($round_up = config('site.round_up', false)) !== false) {
			$price = ceil($price / (int)$round_up) * (int)$round_up;
		}

		return (float)$price;
	}

	public function convert($price, $from = 978, $to = 643, $quantity = 1, $rounded = true, $format = false)
	{
		$currencies = Models\Currency::query()->find([$from, $to]);
		$fromCurrency = $currencies->where('id', $from)->first();
		$toCurrency = $currencies->where('id', $to)->first();
		if ($from != $to) {
			$price = $toCurrency->getAttribute('rates') == 1
				? $price * $fromCurrency->getAttribute('rates')
				: $price / $toCurrency->getAttribute('rates');
		}

		$price *= $quantity;

		if ($rounded === true) {
			$price = $this->round($price);
		}

		if ($format === false) {
			return (float)$price;
		}

		return $this->formatPrice($price, $toCurrency);

	}

	public function formatPrice($price, Models\Currency $currency)
	{
		$result = [
			$currency->getAttribute('symbol_left'),
			number_format($price, $currency->getAttribute('rates') == 1 ? 0 : 2, '.', ' '),
			$currency->getAttribute('symbol_right'),
		];

		return trim(implode(' ', $result));
	}

	/**
	 * Округлить цену
	 *
	 * @param $price
	 *
	 * @return float
	 */
	public function round($price)
	{

		if (($round = config('site.round', false)) !== false) {
			$price = round($price, $round);
		}

		if (($round_up = config('site.round_up', false)) !== false) {
			$price = ceil($price / (int)$round_up) * (int)$round_up;
		}

		return $price;
	}

	/**
	 * Проверить, является ли текущий пользователь администратором
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		if ($user = $this->user()) {
			return $user->admin == 1;
		}

		return false;
	}

	/**
	 * Получить текущего аутентифицированного пользователя
	 *
	 * @return \Illuminate\Foundation\Auth\User|null
	 */
	public function user()
	{
		return $this->app->auth->user();
	}

}
