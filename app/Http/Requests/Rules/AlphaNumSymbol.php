<?php

namespace App\Http\Requests\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumSymbol implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->hasInvalidCharacters($value)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.alpha_num_symbol');
    }

    public function hasInvalidCharacters($password)
    {
        $pattern = '/[^\w`~!@#$%^&*()_\-=+\[\]{};:\'"<>,.?\/\\\\]+/';
        return preg_match($pattern, $password);
    }
}
