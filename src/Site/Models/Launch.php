<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Launch extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'launches';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'phone', 'address',
        'document_name', 'document_number', 'document_date',
        'document_who',
    ];

	/**
	 * @var array
	 */
    protected $casts = [
        'name'            => 'string',
        'country_id'      => 'integer',
        'phone'           => 'string',
        'address'         => 'string',
        'document_name'   => 'string',
        'document_number' => 'string',
        'document_date'   => 'date:Y-m-d',
        'document_who'    => 'string',
    ];

	/**
	 * @var array
	 */
    protected $dates = [
        'document_date'
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

    public function getDocumentDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d.m.Y') : null;
    }

    public function setDocumentDateAttribute($value)
    {
        $this->attributes['document_date'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
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
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

}
