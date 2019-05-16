<?php

namespace QuadStudio\Service\Site\Concerns;

use QuadStudio\Service\Site\Models\Country;

trait Phoneable
{

    /**
     * @param $value
     * @return mixed|null
     */
    public function getPhoneAttribute($value)
    {
        return $value ? preg_replace(config('site.phone.get.pattern'), config('site.phone.get.replacement'), $value) : null;
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value ? preg_replace(config('site.phone.set.pattern'), config('site.phone.set.replacement'), $value) : null;
    }

    /**
     * @return string
     */
    public function getPhoneNumberAttribute()
    {
        if ($this->getAttribute('phone')) {
            return $this->country()->first()->getAttribute('phone') . ' ' . $this->getAttribute('phone');
        }

        return '';

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}