<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationBrand extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'authorization_brands';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Типы авторизаций
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorization_types()
    {
        return $this->hasMany(AuthorizationType::class, 'brand_id');
    }

}
