<?php

namespace QuadStudio\Service\Site\Concerns;

trait AttachRegions
{
    /**
     * Attach multiple regions to a user
     *
     * @param mixed $regions
     */
    public function attachRegions(array $regions)
    {
        foreach ($regions as $region) {
            $this->attachRegion($region);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $region
     */
    public function attachRegion($region)
    {
        if (is_object($region)) {
            $region = $region->getKey();
        }
        if (is_array($region)) {
            $region = $region['id'];
        }
        $this->regions()->attach($region);
    }

    /**
     * Detach multiple regions from a user
     *
     * @param mixed $regions
     */
    public function detachRegions(array $regions)
    {
        if (!$regions) {
            $regions = $this->regions()->get();
        }
        foreach ($regions as $region) {
            $this->detachRegion($region);
        }
    }

    /**
     * @param $regions
     */
    public function syncRegions($regions)
    {
        if (!is_array($regions)) {
            $regions = [$regions];
        }
        $this->regions()->sync($regions);
    }



    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $region
     */
    public function detachRegion($region)
    {
        if (is_object($region)) {
            $region = $region->getKey();
        }
        if (is_array($region)) {
            $region = $region['id'];
        }
        $this->regions()->detach($region);
    }
}