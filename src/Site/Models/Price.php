<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'prices';
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
     * Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(PriceType::class);
    }

    public function price(){

        $price = $this->getAttribute('price') * $this->currency['rates'];

        if (($round = config('shop.round', false)) !== false) {
            $price = round($price, $round);
        }

        if (($round_up = config('shop.round_up', false)) !== false) {
            $price = ceil($price / (int)$round_up) * (int)$round_up;
        }

        return $price;
    }


}
