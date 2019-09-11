<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Pointer extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['element_id', 'x', 'y'];

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
