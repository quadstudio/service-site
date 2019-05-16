<?php

namespace QuadStudio\Service\Site\Concerns;

use QuadStudio\Service\Site\Models\Product;

trait AttachDetails
{
    /**
     * Attach multiple details to a user
     *
     * @param mixed $details
     */
    public function attachDetails(array $details)
    {
        foreach ($details as $detail) {
            $this->attachDetail($detail);
        }
    }


    /**
     * Добавить аналог
     *
     * @param mixed $detail
     */
    public function attachDetail($detail)
    {
        if (is_object($detail)) {
            $detail = $detail->getKey();
        }
        if (is_array($detail)) {
            $detail = $detail['id'];
        }
        $this->details()->attach($detail);
    }

    /**
     * Detach multiple details from a user
     *
     * @param mixed $details
     */
    public function detachDetails(array $details)
    {
        if (!$details) {
            $details = $this->details()->get();
        }
        foreach ($details as $detail) {
            $this->detachDetail($detail);
        }
    }

    /**
     * @param $details
     */
    public function syncDetails($details)
    {
        if (!is_array($details)) {
            $details = [$details];
        }
        $this->details()->sync($details);
    }

    /**
     * Детали товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function details()
    {
        return $this->belongsToMany(
            Product::class,
            'relations',
            'product_id',
            'relation_id');
    }

    /**
     * Удалить аналог
     *
     * @param mixed $detail
     */
    public function detachDetail($detail)
    {
        if (is_object($detail)) {
            $detail = $detail->getKey();
        }
        if (is_array($detail)) {
            $detail = $detail['id'];
        }
        $this->details()->detach($detail);
    }

}