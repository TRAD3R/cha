<?php
/**
 *  Класс для обработки строковых значений
 */
namespace App\Helpers;


use App\Lib\Helpers\FileHelper;

class TextHelper
{
    public static function upperFirstChar($string)
    {
        $firstChar = mb_convert_case(mb_substr($string, 0, 1), MB_CASE_UPPER);

        return $firstChar . mb_substr($string, 1);
    }

    public static function createUsingFilename($sku, $num)
    {
        $str = strtolower($sku . "-using-" . $num);
        
        return FileHelper::createFilename($str);
    }
    
    
}