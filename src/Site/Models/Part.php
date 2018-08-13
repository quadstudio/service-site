<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Facades\Site;

class Part extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'product_id', 'count', 'cost'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'parts';
    }

    /**
     * Товар
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fixPrice()
    {

    }

    /**
     * Отчет по ремониу
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    /**
     * Стоимость детали ИТОГО
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->cost() * $this->count;
    }

    /**
     * Стоимость детали
     *
     * @return float
     */
    public function cost()
    {
        switch ($this->repair->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->cost;
            default:
                return $this->price * $this->rates;
        }
    }

    /**
     * Коэффициент курса валюты
     *
     * @return float
     */
    public function getRatesAttribute()
    {
        return Site::currencyRates($this->repair->user->price_type->currency, $this->repair->user->currency);
    }

    /**
     * Цена детали
     *
     * @return float
     */
    public function getPriceAttribute()
    {
        return $this->product->prices()->where('type_id', $this->repair->user->price_type_id)->sum('price');
    }

    /**
     * Узнать, имеет ли деталь цену
     *
     * @return bool
     */
    public function hasPrice()
    {
        return (float)$this->price > 0.00;
    }

}
