<?php

namespace QuadStudio\Service\Site\Concerns;

use QuadStudio\Service\Site\Models\Product;

trait AttachAnalogs
{
    /**
     * Attach multiple analogs to a user
     *
     * @param mixed $analogs
     */
    public function attachAnalogs(array $analogs)
    {
        foreach ($analogs as $analog) {
            $this->attachAnalog($analog);
        }
    }


    /**
     * Добавить аналог
     *
     * @param mixed $analog
     */
    public function attachAnalog($analog)
    {
        if (is_object($analog)) {
            $analog = $analog->getKey();
        }
        if (is_array($analog)) {
            $analog = $analog['id'];
        }
        $this->analogs()->attach($analog);
    }

    /**
     * Detach multiple analogs from a user
     *
     * @param mixed $analogs
     */
    public function detachAnalogs(array $analogs)
    {
        if (!$analogs) {
            $analogs = $this->analogs()->get();
        }
        foreach ($analogs as $analog) {
            $this->detachAnalog($analog);
        }
    }

    /**
     * @param $analogs
     */
    public function syncAnalogs($analogs)
    {
        if (!is_array($analogs)) {
            $analogs = [$analogs];
        }
        $this->analogs()->sync($analogs);
    }

    /**
     * Аналоги товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function analogs()
    {
        return $this->belongsToMany(
            Product::class,
            'analogs',
            'product_id',
            'analog_id');
    }

    /**
     * Удалить аналог
     *
     * @param mixed $analog
     */
    public function detachAnalog($analog)
    {
        if (is_object($analog)) {
            $analog = $analog->getKey();
        }
        if (is_array($analog)) {
            $analog = $analog['id'];
        }
        $this->analogs()->detach($analog);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function analogs_array()
    {

        $analogs = collect([]);
        if (!is_null($this->getAttribute('old_sku'))) {
            $analogs->push($this->getAttribute('old_sku'));
        }

        if ($this->analogs()->exists()) {
            foreach ($this->analogs()->get() as $analog) {
                if ($analog->hasSku()) {
                    $analogs->push($analog->getAttribute('sku'));
                }
            }
        }

        return $analogs;
    }

}