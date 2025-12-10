<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueCiapFieldsRegister implements Rule
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
        $uniqueCount = DB::table('profile')
            ->where('ciap1', request('ciap1'))
            ->where('ciap2', request('ciap2'))
            ->where('ciap3', request('ciap3'))
            ->where('ciapnum', request('ciapnum'))
            ->count();

        // If uniqueCount is 0, the combination is unique
        return $uniqueCount === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return db_translate('alert_ciap_unique');
    }
}
