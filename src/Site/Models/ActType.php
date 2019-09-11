<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ActType extends Model
{
    /**
     * @var string
     */
    protected $table = 'act_types';

    /**
     * Акты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acts()
    {
        return $this->hasMany(Act::class, 'type_id');
    }

}
