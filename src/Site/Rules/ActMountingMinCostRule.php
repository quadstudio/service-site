<?php

namespace QuadStudio\Service\Site\Rules;

use Illuminate\Contracts\Validation\Rule;
use QuadStudio\Service\Site\Models\Mounting;

class ActMountingMinCostRule implements Rule
{

    private $_contragent;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  array $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->_contragent = ($mountings = Mounting::query()->find($value))->first()->contragent->getAttribute('name');

        return $mountings->sum('total') >= config('site.mounting_min_cost', 3000);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('site::mounting.error.act.min_cost', [
            'cost'       => config('site.mounting_min_cost', 3000),
            'contragent' => $this->_contragent,
        ]);
    }
}