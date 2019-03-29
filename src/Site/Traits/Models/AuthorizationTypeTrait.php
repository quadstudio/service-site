<?php

namespace QuadStudio\Service\Site\Traits\Models;

use QuadStudio\Service\Site\Models\AuthorizationType;

trait AuthorizationTypeTrait
{
    /**
     * Attach multiple types to a user
     *
     * @param mixed $types
     */
    public function attachTypes(array $types)
    {
        foreach ($types as $type) {
            $this->attachType($type);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $type
     */
    public function attachType($type)
    {
        if (is_object($type)) {
            $type = $type->getKey();
        }
        if (is_array($type)) {
            $type = $type['id'];
        }
        $this->types()->attach($type);
    }

    /**
     * Detach multiple types from a user
     *
     * @param mixed $types
     */
    public function detachTypes(array $types)
    {
        if (!$types) {
            $types = $this->types()->get();
        }
        foreach ($types as $type) {
            $this->detachType($type);
        }
    }

    /**
     * @param $types
     */
    public function syncTypes($types)
    {
        if (!is_array($types)) {
            $types = [$types];
        }
        $this->types()->sync($types);
    }

    /**
     * Many-to-Many relations with type model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(
            AuthorizationType::class,
            'authorization_type',
            'authorization_id',
            'type_id');
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $type
     */
    public function detachType($type)
    {
        if (is_object($type)) {
            $type = $type->getKey();
        }
        if (is_array($type)) {
            $type = $type['id'];
        }
        $this->types()->detach($type);
    }
}