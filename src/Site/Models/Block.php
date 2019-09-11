<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Sortable;

class Block extends Model
{

    use Sortable;
    /**
     * @var string
     */
    protected $table = 'blocks';
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'sort_order'
    ];

    /**
     * Взрывные схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schemes()
    {
        return $this->hasMany(Scheme::class);
    }

}
