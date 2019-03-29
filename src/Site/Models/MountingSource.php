<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MountingSource extends Model
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'mounting_sources';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class, 'source_id');
    }

}
