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
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'sort_order'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'blocks';
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

}
