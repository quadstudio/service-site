<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Launch extends Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'phone', 'address',
        'document_name', 'document_number', 'document_date',
        'document_who',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'launches';
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

    public function document_date()
    {
        return !is_null($this->document_date) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->document_date))->format('d.m.Y') : '';
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        return $this->repairs()->count() == 0;
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
