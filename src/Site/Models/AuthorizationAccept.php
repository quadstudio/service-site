<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Concerns\AttachAuthorizationTypes;

class AuthorizationAccept extends Model
{

    use AttachAuthorizationTypes;

    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'role_id', 'user_id', 'type_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'authorization_accepts';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AuthorizationType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
