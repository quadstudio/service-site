<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\Messagable;


class Mounting extends Model implements Messagable
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'status_id', 'serial_id', 'product_id',
        'source_id', 'source_other',
        'bonus_social', 'bonus',
        'date_trade', 'date_mounting',
        'engineer_id', 'trade_id', 'contragent_id',
        'source_id', 'country_id',
        'client', 'phone_primary', 'phone_secondary',
        'address', 'social_url',
        'social_enabled', 'comment'
    ];
    protected $casts = [

        'serial_id'       => 'string',
        'product_id'      => 'string',
        'source_id'       => 'integer',
        'source_other'    => 'string',
        'status_id'       => 'integer',
        'contragent_id'   => 'integer',
        'bonus'           => 'integer',
        'bonus_social'    => 'integer',
        'date_trade'      => 'date:Y-m-d',
        'date_mounting'   => 'date:Y-m-d',
        'engineer_id'     => 'integer',
        'trade_id'        => 'integer',
        'country_id'      => 'string',
        'phone_primary'   => 'string',
        'phone_secondary' => 'string',
        'social_url'      => 'string',
        'client'          => 'string',
        'address'         => 'string',
        'social_enabled'  => 'boolean',
        'comment'         => 'string',
    ];

    protected $dates = [
        'date_trade',
        'date_mounting'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'mountings';
    }

    protected static function boot()
    {

        static::creating(function ($model) {

            /** @var Mounting $model */
            $model->setAttribute('bonus', $model->product->mounting_bonus->value);
            $model->setAttribute('social_bonus', $model->product->mounting_bonus->social);
        });

    }

    /**
     * @param $value
     */
    public function setDateTradeAttribute($value)
    {
        $this->attributes['date_trade'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    /**
     * @param $value
     */
    public function setDateMountingAttribute($value)
    {
        $this->attributes['date_mounting'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function getPhonePrimaryAttribute($value)
    {
        return $value ? preg_replace(config('site.phone.get.pattern'), config('site.phone.get.replacement'), $value) : null;
    }

    /**
     * @param $value
     */
    public function setPhonePrimaryAttribute($value)
    {
        $this->attributes['phone_primary'] = $value ? preg_replace(config('site.phone.set.pattern'), config('site.phone.set.replacement'), $value) : null;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function getPhoneSecondaryAttribute($value)
    {
        return $value ? preg_replace(config('site.phone.get.pattern'), config('site.phone.get.replacement'), $value) : null;
    }

    /**
     * @param $value
     */
    public function setPhoneSecondaryAttribute($value)
    {
        $this->attributes['phone_secondary'] = $value ? preg_replace(config('site.phone.set.pattern'), config('site.phone.set.replacement'), $value) : null;
    }

    public function getTotalAttribute()
    {
        return $this->getAttribute('bonus') + $this->getAttribute('enabled_social_bonus');
    }

    public function getEnabledSocialBonusAttribute()
    {
        return $this->getAttribute('social_enabled') == 1 ? $this->getAttribute('social_bonus') : 0;
    }


    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function detachFiles()
    {
        foreach ($this->files as $file) {
            $file->fileable_id = null;
            $file->fileable_type = null;
            $file->save();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(MountingStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(MountingSource::class);
    }

    /**
     * Акт выполненных работ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function act()
    {
        return $this->belongsTo(Act::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Страна
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Торговая организация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    /**
     * Сервисный инженер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
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
     * @return string
     */
    function messageSubject()
    {
        return ucfirst(trans('site::mounting.mounting')) . ' № ' . $this->getAttribute('id');
    }

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageRoute()
    {
        return route((auth()->user()->admin == 1 ? 'admin.' : '') . 'mountings.show', $this);
    }

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageMailRoute()
    {
        return route((auth()->user()->admin == 1 ? '' : 'admin.') . 'mountings.show', $this);
    }
}
