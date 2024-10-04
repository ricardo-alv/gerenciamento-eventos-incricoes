<?php

use Carbon\Carbon;

if (!function_exists('formatDateBr')) {

    function formatDateBr($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('formatDateTimeBr')) {

    function formatDateTimeBr($dateTime)
    {       
        return Carbon::parse($dateTime)->format('d/m/Y H:i:s');
    }
}
