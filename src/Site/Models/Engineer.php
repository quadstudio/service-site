<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'engineers';

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
     * Отчеты по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class);
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
     * Сертификаты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

}
