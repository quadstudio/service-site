<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    /**
     * @var string
     */
    protected $table;

    public $incrementing = false;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'serials';
    }

    /**
     * Тип файла
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
