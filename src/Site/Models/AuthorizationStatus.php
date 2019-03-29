<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationStatus extends Model
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
        $this->table = 'authorization_statuses';
    }

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
