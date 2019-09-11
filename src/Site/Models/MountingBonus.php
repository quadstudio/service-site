<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MountingBonus extends Model
{

    protected $fillable = [
        'product_id', 'value', 'social',
    ];

    protected $casts = [
        'product_id' => 'string',
        'value'      => 'integer',
        'social'     => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
