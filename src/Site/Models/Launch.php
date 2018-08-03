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
        $this->table = env('DB_PREFIX', ''). 'launches';
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

}
