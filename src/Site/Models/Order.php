<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['status_id', 'comment'];

    public function id(){
        return str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'orders';
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return $this->items->sum(function ($item) {
            return $item->subtotal();
        });
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

}
