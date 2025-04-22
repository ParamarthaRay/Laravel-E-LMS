<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class ValidGregorianDate implements Rule
{
    public $error;

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        try {
            // Try to parse the date with Carbon using d-m-Y format
            $date = Carbon::createFromFormat('d-m-Y', $value)->setTimezone('Asia/Kolkata');

            return true;
        } catch (\Exception $exception) {
            $this->error = $exception->getMessage()." - {$value}";

            return false;
        }
    }

    public function message()
    {
        return 'Please select a valid date'." ({$this->error})";
    }
}
