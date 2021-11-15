<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserExists implements Rule
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
        return User::find($value) ?? false;
    }

    /**
     * Get the validation error message.
     *
     * @return string[]
     */
    public function message()
    {
        return ['The :attribute was not found.'];
    }
}
