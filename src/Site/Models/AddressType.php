<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    /**
     * @var string
     */
    protected $table = 'address_types';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'type_id');
    }

}
