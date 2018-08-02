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
        'product_id', 'count'
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

    /**
     * Отчет по ремониу
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }


    public function getTotalAttribute()
    {
        switch ($this->repair->getAttribute('status_id')) {
            case 5:
            case 6:
                $result = $this->cost * $this->count;
                break;
            default:
                $result = $this->product->prices()->where('type_id', $this->repair->user->price_type_id)->sum('price')
                    * $this->count * Site::currencyRates($this->repair->user->price_type->currency, $this->repair->user->currency);
                break;
        }

        return $result;
    }


}
