<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueCiapFields implements Rule
{
    /**
     * The ID of the record to be excluded from the uniqueness check.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Create a new rule instance.
     *
     * @param mixed $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
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
        // Check uniqueness among ciap1, ciap2, ciap3, and ciapnum fields
        $uniqueCount = DB::table('profile')
            ->where('ciap1', request('ciap1'))
            ->where('ciap2', request('ciap2'))
            ->where('ciap3', request('ciap3'))
            ->where('ciapnum', request('ciapnum'))
            ->where('user_id', '!=', $this->id) // Exclude the current record
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
        return db_translate('alert_ciap_unique2');
    }
}
