<?php

if (!function_exists('formattedPrice')) {
    function formattedPrice($number, $currency = 'Rp')
    {
        return $currency . ' ' . number_format($number, 0, ',', '.');
    }
}
