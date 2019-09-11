<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'authorization_statuses';

    /**
     * Авторизации
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorizations()
    {
        return $this->hasMany(Authorization::class, 'status_id');
    }

}
