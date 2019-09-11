<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'title', 'name', 'type_id', 'content'
    ];

    /**
     * Тип шаблона
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TemplateType::class);
    }

}
