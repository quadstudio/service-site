<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStatus extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'member_statuses';

    /**
     * Заявки
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'status_id');
    }

}
