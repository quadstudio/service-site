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

            $model->address = empty($model->address) ? "" : $model->address ;
        });

        static::updating(function ($model) {
            $model->address = empty($model->address) ? "" : $model->address ;
        });
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
        return $this->repairs()->count() == 0;
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
     * Отформатированный номер телефона
     * @return string
     */
    public function format()
    {
        $result = [$this->country->getAttribute('phone')];
        if (preg_match('/^(\d{3})(\d{3})(\d{2})(\d{2})$/', $this->getAttribute('phone'), $matches)) {
            $result[] = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3] . '-' . $matches[4];
        } else {
            $result[] = $this->getAttribute('phone');
        }


        return implode(' ', $result);
    }

}
