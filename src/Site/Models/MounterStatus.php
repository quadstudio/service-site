<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MounterStatus extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'mounter_statuses';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mounters()
    {
        return $this->hasMany(Mounter::class, 'status_id');
    }

}
