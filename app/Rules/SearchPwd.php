<?php

namespace App\Rules;

use App\Models\BaseModel;
use Illuminate\Contracts\Validation\Rule;

class SearchPwd implements Rule
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
        if (dujiaoka_config_get('is_open_search_pwd') == BaseModel::STATUS_OPEN && empty($value)) {
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
        return __('dujiaoka.prompt.search_password_can_not_be_empty');
    }
}
