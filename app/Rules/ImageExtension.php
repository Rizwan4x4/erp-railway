<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageExtension implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $allowedExtensions = ['png', 'jpg', 'jpeg'];

        $extension = strtolower($value->getClientOriginalExtension());

        return in_array($extension, $allowedExtensions);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid image file. Only PNG, JPG, and JPEG files are allowed.';
    }
}