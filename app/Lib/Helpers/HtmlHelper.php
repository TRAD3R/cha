<?php


namespace App\Helpers;


use Yii;

class HtmlHelper
{
    public static function resetButton($url, $text = null) 
    {
        $text = is_null($text) ? Yii::t('front', 'RESET') : $text;
        
        $button = "<a href='{$url}' class='btn btn-empty'>{$text}</a>";
        
        return $button;
    }
}