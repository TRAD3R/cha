<?php


namespace App\Tables;


abstract class AbstractTS
{
    const GROUP_CUSTOM = 'custom';
    const GROUP_MAINCHARACTERISTIC = 'mainCharacteristic';
    const GROUP_PARAMS = 'params';
    const GROUP_PRICE = 'price';
    const GROUP_CONTENT = 'content';

    const DATE_CREATED = 1;
    const BRAND = 2;
    const TITLE = 3;
    const PRICE = 4;
    const IMAGE = 5;
    const ID = 6;


    public static function getTitles() {}

    public static function getSortedColumns() {}
    
    public static function getConstant($staticPart, $dymanicPart) {}
}