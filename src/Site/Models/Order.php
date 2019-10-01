<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Concerns\Schedulable;
use QuadStudio\Service\Site\Contracts\SingleFileable;
use Site;


class Order extends Model implements Messagable, SingleFileable
{

	use Schedulable;

	protected $fillable = [
		'status_id',
		'contragent_id',
		'address_id',
		'contacts_comment',
		'in_stock_type',
		'brother_id',
	];

	/**
	 * @param $currency_id
	 * @param bool $rounded
	 * @param bool $format
	 *
	 * @return mixed
	 */
	public function total($currency_id, $rounded = true, $format = false)
	{

		$currency = Currency::query()->findOrFail($currency_id);
		$sum = $this->items->sum(function ($item) use ($currency_id) {
			return Site::convert($item->price, $item->currency_id, is_null($currency_id) ? $item->currency_id : $currency_id, $item->quantity, false);
		});
		if ($rounded === true) {
			$sum = Site::round($sum);
		}

		if ($format === false) {
			return $sum;
		}

		return Site::formatPrice($sum, $currency);

	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function file()
	{
		return $this->morphOne(File::class, 'fileable');
	}

	/**
	 * @param int $currency_id
	 */
	public function recalculate($currency_id = 643)
	{
		/** @var OrderItem $item */
		foreach ($this->items as $item) {
			$item->recalculate($currency_id);
		}
	}

	/**
	 * @return mixed
	 */
	public function quantity()
	{
		return $this->items->sum('quantity');
	}


	/**
	 * Order items
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}

	/**
	 * Контрагент
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function contragent()
	{
		return $this->belongsTo(Contragent::class);
	}

	/**
	 * Склад отгрузки
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function address()
	{
		return $this->belongsTo(Address::class);
	}

	public function hasGuid()
	{
		return !is_null($this->getAttribute('guid'));
	}

	/**
	 * Сообщения
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function messages()
	{
		return $this->morphMany(Message::class, 'messagable');
	}

	/**
	 * User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Status
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function status()
	{
		return $this->belongsTo(OrderStatus::class);
	}

	/**
	 * @return string
	 */
	function messageSubject()
	{
		return trans('site::order.order') . ' ' . $this->id;
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageRoute()
	{
		if (auth()->user()->admin == 1) {
			$route = 'admin.orders.show';
		} elseif ($this->address->addressable->id == auth()->user()->getAuthIdentifier()) {
			$route = 'distributors.show';
		} else {
			$route = 'orders.show';
		}

		return route($route, $this);
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageMailRoute()
	{
		if (auth()->user()->admin == 1 || $this->address->addressable->id == auth()->user()->getAuthIdentifier()) {
			$route = 'orders.show';
		} elseif ($this->address->addressable->admin == 1) {
			$route = 'admin.orders.show';
		} else {
			$route = 'distributors.show';
		}

		return route($route, $this);

	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageStoreRoute()
	{
		if ($this->address->addressable->id == auth()->user()->getAuthIdentifier()) {
			$route = 'distributors.message';
		} else {
			$route = 'orders.message';
		}

		return route($route, $this);
	}

	/** @return User */
	function messageReceiver()
	{
		return $this->address->addressable->id == auth()->user()->getAuthIdentifier()
			? $this->user
			: $this->address->addressable;
	}

	/**
	 * @return string
	 */
	function fileStorage()
	{
		return 'payments';
	}
}
