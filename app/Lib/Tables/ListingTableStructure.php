<?php


namespace App\Tables;

use Yii;

class ListingTableStructure extends AbstractTS
{
    const SEQUENCE_NUMBER = 0;
    const SELECT_ALL = 100;
    
    public static function getTitles()
    {
        return [
          self::SEQUENCE_NUMBER => Yii::t('front', 'SECUENCE_NUMBER'),
          self::SELECT_ALL => Yii::t('front', 'SELECT_ALL'),
          self::DATE_CREATED => Yii::t('front', 'DATE_CREATED'),
          self::TITLE => Yii::t('front', 'TITLE'),
        ];
    }

    /**
     * Столбцы, по которым можно сортировать
     * @return array
     */
    public static function getSortedColumns()
    {
        return [
            self::DATE_CREATED,
            self::TITLE,
        ];
    }

}