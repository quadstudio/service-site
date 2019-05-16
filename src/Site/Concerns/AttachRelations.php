<?php

namespace QuadStudio\Service\Site\Concerns;

use QuadStudio\Service\Site\Models\Product;

trait AttachRelations
{
    /**
     * Attach multiple relations to a user
     *
     * @param mixed $relations
     */
    public function attachRelations(array $relations)
    {
        foreach ($relations as $relation) {
            $this->attachRelation($relation);
        }
    }


    /**
     * Добавить аналог
     *
     * @param mixed $relation
     */
    public function attachRelation($relation)
    {
        if (is_object($relation)) {
            $relation = $relation->getKey();
        }
        if (is_array($relation)) {
            $relation = $relation['id'];
        }
        $this->relations()->attach($relation);
    }

    /**
     * Detach multiple relations from a user
     *
     * @param mixed $relations
     */
    public function detachRelations(array $relations)
    {
        if (!$relations) {
            $relations = $this->relations()->get();
        }
        foreach ($relations as $relation) {
            $this->detachRelation($relation);
        }
    }

    /**
     * @param $relations
     */
    public function syncRelations($relations)
    {
        if (!is_array($relations)) {
            $relations = [$relations];
        }
        $this->relations()->sync($relations);
    }

    /**
     * Детали товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function relations()
    {
        return $this->belongsToMany(
            Product::class,
            'relations',
            'relation_id',
            'product_id');
    }

    /**
     * Удалить аналог
     *
     * @param mixed $relation
     */
    public function detachRelation($relation)
    {
        if (is_object($relation)) {
            $relation = $relation->getKey();
        }
        if (is_array($relation)) {
            $relation = $relation['id'];
        }
        $this->relations()->detach($relation);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function relation_equipments()
    {

        $equipments = collect([]);
        foreach ($this->relations()->where('enabled', 1)->get() as $relation) {
            if (!is_null($relation->getAttribute('equipment_id'))) {
                $equipments->put($relation->getAttribute('equipment_id'), $relation->equipment);
            }
        }

        return $equipments;
    }

}