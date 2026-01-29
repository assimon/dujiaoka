<?php

namespace App\Rules;

use App\Models\BaseModel;
use Illuminate\Contracts\Validation\Rule;

class VerifyImg implements Rule
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
        if (dujiaoka_config_get('is_open_img_code') == BaseModel::STATUS_OPEN && !captcha_check($value)) {
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
        return __('dujiaoka.prompt.image_verify_code_error');
    }
}
