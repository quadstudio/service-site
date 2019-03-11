<?php

namespace QuadStudio\Service\Site\Traits\Models;

use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Region;

trait RegionStorehouseTrait
{
    /**
     * Attach multiple addresses to a user
     *
     * @param mixed $addresses
     */
    public function attachAddresses(array $addresses)
    {
        foreach ($addresses as $address) {
            $this->attachRegion($address);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $address
     */
    public function attachRegion($address)
    {
        if (is_object($address)) {
            $address = $address->getKey();
        }
        if (is_array($address)) {
            $address = $address['id'];
        }
        $this->storehouses()->attach($address);
    }

    /**
     * Detach multiple addresses from a user
     *
     * @param mixed $addresses
     */
    public function detachAddresses(array $addresses)
    {
        if (!$addresses) {
            $addresses = $this->storehouses()->get();
        }
        foreach ($addresses as $address) {
            $this->detachRegion($address);
        }
    }

    /**
     * @param $addresses
     */
    public function syncAddresses($addresses)
    {
        if (!is_array($addresses)) {
            $addresses = [$addresses];
        }
        $this->storehouses()->sync($addresses);
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
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $address
     */
    public function detachRegion($address)
    {
        if (is_object($address)) {
            $address = $address->getKey();
        }
        if (is_array($address)) {
            $address = $address['id'];
        }
        $this->storehouses()->detach($address);
    }
}