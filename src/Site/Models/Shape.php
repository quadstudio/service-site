<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    /**
     * @var string
     */

    protected $fillable = ['element_id', 'shape', 'coords'];

    /**
     * Элемент схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
