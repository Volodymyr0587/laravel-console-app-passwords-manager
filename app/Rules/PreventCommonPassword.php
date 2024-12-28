<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PreventCommonPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $commonPasswords = config()->get('common_passwords');

        if (in_array($value, $commonPasswords)) {
            $fail('The selected password is not strong enough. Try again with a safer string');
        }
    }
}
