<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Datasheet extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'date_from', 'date_to', 'tags', 'type_id', 'active', 'file_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'datasheets';
    }

    /**
     * Тип документации
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DatasheetType::class);
    }

    /**
     * Взрывные схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schemes()
    {
        return $this->hasMany(Scheme::class);
    }

    /**
     * Файл
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * @return null|string
     */
    public function date_from_to()
    {
        $result = [];
        if (!is_null($date_from = $this->date_from())) {
            $result[] = trans('site::datasheet.date_from');
            $result[] = $date_from;
        }
        if (!is_null($date_to = $this->date_to())) {
            if (!empty($result)) {
                $result[] = '-';
            }
            $result[] = trans('site::datasheet.date_to');
            $result[] = $date_to;
        }


        if (!empty($result)) {
            return '(' . implode(' ', $result) . ')';
        }

        return null;
    }

    public function date_from()
    {
        return !is_null($this->date_from) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_from))->format('d.m.Y') : null;
    }

    public function date_to()
    {
        return !is_null($this->date_to) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_to))->format('d.m.Y') : null;
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            env('DB_PREFIX', '') . 'datasheet_product',
            'datasheet_id',
            'product_id'
        );
    }

}
