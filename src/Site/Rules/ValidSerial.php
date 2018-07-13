<?php

namespace QuadStudio\Service\Site\Rules;

use Illuminate\Contracts\Validation\Rule;
use QuadStudio\Service\Site\Models\Serial;

class ValidSerial implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !is_null(Serial::find($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('site::repair.error.serial_find');
    }
}