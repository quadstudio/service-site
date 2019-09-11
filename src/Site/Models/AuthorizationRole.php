<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Rbac\Models\Role;

class AuthorizationRole extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'authorization_roles';

    /**
     * @var array
     */
    protected $fillable = ['name', 'title', 'role_id', 'address_type_id'];

    /**
     * @return bool
     */
    public function canCreate(){
       return !Auth::user()->authorizations()->where('role_id', $this->getAttribute('role_id'))->where('status_id', 1)->exists();
    }

    /**
     * Роль
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Тип адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address_type()
    {
        return $this->belongsTo(AddressType::class);
    }

}
