<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'phone', 'address'
    ];


    protected $casts = [
        'name'       => 'string',
        'country_id' => 'integer',
        'phone'      => 'string',
        'address'    => 'string',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'trades';
    }

    protected static function boot()
    {
        static::creating(function ($model) {

            $model->address = empty($model->address) ? "" : $model->address;
        });

        static::updating(function ($model) {
            $model->address = empty($model->address) ? "" : $model->address;
        });
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
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Страна местонахождения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        return $this->repairs()->count() == 0 && $this->mountings()->count() == 0;
    }

    /**
     * Отчеты по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Отчеты по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class);
    }

}
