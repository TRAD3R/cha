<?php


namespace App\Lib\Helpers;


class FileHelper
{
    public static function createFilename($str)
    {
        $str = preg_replace("~[^a-z0-9-_/]~", "-", $str);
        $str = preg_replace("~-+~", "-", $str);
        $str .= ".jpg";
        
        return $str;
    }
}