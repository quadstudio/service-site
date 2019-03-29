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
    protected $table;

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'authorization_brands';
    }

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
