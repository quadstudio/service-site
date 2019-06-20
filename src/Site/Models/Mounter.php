<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mounter extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'status_id', 'mounter_at',
        'equipment_id', 'product_id',
        'country_id', 'model',
        'client', 'phone',
        'address', 'comment'
    ];
    protected $casts = [

        'status_id'       => 'integer',
        'user_address_id' => 'integer',
        'mounter_at'      => 'date:Y-m-d',
        'equipment_id'    => 'integer',
        'product_id'      => 'string',
        'model'           => 'string',
        'country_id'      => 'string',
        'phone'           => 'string',
        'client'          => 'string',
        'address'         => 'string',
        'comment'         => 'string',
    ];

    protected $dates = [
        'mounter_at'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'mounters';
    }

    /**
     * @param $value
     */
    public function setMounterAtAttribute($value)
    {
        $this->attributes['mounter_at'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function getPhoneAttribute($value)
    {
        return $value ? preg_replace(config('site.phone.get.pattern'), config('site.phone.get.replacement'), $value) : null;
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value ? preg_replace(config('site.phone.set.pattern'), config('site.phone.set.replacement'), $value) : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(MounterStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAddress()
    {
        return $this->belongsTo(Address::class, 'user_address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
