<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MountingStatus extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class, 'status_id');
    }

}
