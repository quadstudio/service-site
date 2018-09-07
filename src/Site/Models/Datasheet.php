<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\SingleFileable;

class Datasheet extends Model implements SingleFileable
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'date_from', 'date_to', 'name', 'tags', 'active', 'file_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'datasheets';
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

    /**
     * Добавить связь документация - оборудование
     *
     * @param mixed $product
     */
    public function attachProduct($product)
    {
        if (is_object($product)) {
            $product = $product->getKey();
        }
        if (is_array($product)) {
            $product = $product['id'];
        }
        $this->products()->attach($product);
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

    /**
     * Удалить связь документация - оборудование
     *
     * @param mixed $product
     */
    public function detachProduct($product)
    {
        if (is_object($product)) {
            $product = $product->getKey();
        }
        if (is_array($product)) {
            $product = $product['id'];
        }
        $this->products()->detach($product);
    }

}
