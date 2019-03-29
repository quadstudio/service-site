<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MountingStatus extends Model
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
        $this->table = 'mounting_statuses';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class, 'status_id');
    }

}
