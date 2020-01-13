<?php


namespace App\Helpers;


class PriceHelper
{
    public static function toInt($price)
    {
        $floatPrice = (float) sprintf("%.2f", $price);
        return $floatPrice * 100;
    }

    public static function toFloat($price)
    {
        $realPrice = $price / 100;
        return sprintf("%.2f", $realPrice);
    }
}