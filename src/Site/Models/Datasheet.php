<?php

namespace QuadStudio\Service\Site\Models;

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
     * Файл
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
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
