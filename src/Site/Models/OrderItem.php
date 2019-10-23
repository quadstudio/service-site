<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Site;

class OrderItem extends Model
{

	protected $fillable = [
		'product_id', 'name', 'price', 'quantity',
		'currency_id', 'sku', 'weight', 'brand_id', 'unit',
		'type_id', 'service', 'availability', 'weeks_delivery',
	];

	protected static function boot()
	{
		static::creating(function (OrderItem $item) {
			if ($item->order->status_id = 1 && in_array($item->order->in_stock_type, array(1, 2))) {
				$item->setAttribute('price', $item->product->price->getAttribute('price') ?? 0);
				$item->setAttribute('currency_id', $item->product->price->getAttribute('currency_id') ?? 978);
			}
		});
	}

	/**
	 * @return mixed
	 */
	public function subtotal()
	{
		return $this->price * $this->quantity;
	}

	/**
	 * Order
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Product
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	/**
	 * Currency
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}

	/**
	 * @return string
	 */
	public function name()
	{
		$result = [];
		$result[] = $this->name;
		if (mb_strlen($this->sku, "UTF-8") > 0) {
			$result[] = '(' . $this->sku . ')';
		}

		return htmlspecialchars_decode(implode(' ', $result));
	}

	public function convertPrice($currency_id, $quantity)
	{
		return Site::convert($this->getAttribute('price'), $this->getAttribute('currency_id'), $currency_id, $quantity, false, false);
	}

	public function recalculate($currency_id)
	{
		$this->update([
			'currency_id' => $currency_id,
			'price' => $this->convertPrice($currency_id, $this->getAttribute('quantity'))
		]);
	}

}
