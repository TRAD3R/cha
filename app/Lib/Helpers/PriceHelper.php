<?php


namespace App\Helpers;


class PriceHelper
{
    public static function toInt(float $price)
    {
        return number_format($price * 100);
    }

    public static function toFloat($price)
    {
        return (float) number_format($price / 100, 2);
    }
}