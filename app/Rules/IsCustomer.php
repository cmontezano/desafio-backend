<?php

namespace App\Rules;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class IsCustomer implements Rule
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
        return ($user = User::find($value)) && get_class($user->userable) === Customer::class;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only customers can send money.';
    }
}
