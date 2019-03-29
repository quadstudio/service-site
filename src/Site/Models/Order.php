<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Traits\Models\ScheduleTrait;

class Order extends Model implements Messagable
{
    use ScheduleTrait;

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['status_id', 'contragent_id', 'address_id'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'orders';
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
        return route((auth()->user()->admin == 1 ? 'admin.' : '') . 'orders.show', [$this, '#messages-list']);
    }

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageMailRoute()
    {
        return route((auth()->user()->admin == 1 ? '' : 'admin.') . 'orders.show', [$this, '#messages-list']);
    }
}
