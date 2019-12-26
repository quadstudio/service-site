<?php

namespace QuadStudio\Service\Site\Rules;

use Illuminate\Contracts\Validation\Rule;
use QuadStudio\Service\Site\Models\DigiftUser;
use QuadStudio\Service\Site\Models\Serial;

class DigiftUserBlockedRule implements Rule
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
        return DigiftUser::query()->where('id', $value)
	        ->whereHas('user', function ($query){
	        	$query->where('active', 1);
	        })->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('site::digift_expense.error.user_is_blocked');
    }
}