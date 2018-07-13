<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'product_id', 'count'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'parts';
    }

    /**
     * Товар
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
