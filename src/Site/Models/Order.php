<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Concerns\Schedulable;

class Order extends Model implements Messagable
{
    use Schedulable;

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['status_id', 'contragent_id', 'address_id', 'contacts_comment'];

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
        if (auth()->user()->admin == 1) {
            $route = 'admin.orders.show';
        } elseif ($this->address->addressable->id == auth()->user()->getAuthIdentifier()) {
            $route = 'orders.show';
        } else {
            $route = 'distributors.show';
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
}
