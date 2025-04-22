<?php

if (! function_exists('convertToEnglishNumbers')) {
    /**
     * Convert Persian numbers to English numbers.
     *
     * @param  string  $string
     * @return string
     */
    function convertToEnglishNumbers($string)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }
}
