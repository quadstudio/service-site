<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var bool
     */
    public $incrementing = false;
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
        $this->table = 'regions';
    }

    /**
     * Many-to-Many relations with address model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function storehouses()
    {
        return $this->belongsToMany(
            Address::class,
            'address_region',
            'region_id',
            'address_id');
    }

    /**
     * Адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'region_id');
    }

    /**
     * Мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'region_id');
    }

    /**
     * Страна
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Заявки
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'region_id');
    }

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            Address::class,
            'address_region',
            'region_id',
            'address_id'
        );
    }

}
