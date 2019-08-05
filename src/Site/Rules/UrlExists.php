<?php

namespace QuadStudio\Service\Site\Rules;

use Illuminate\Contracts\Validation\Rule;

class UrlExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !url_exists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('site::storehouse.error.url');
    }
}