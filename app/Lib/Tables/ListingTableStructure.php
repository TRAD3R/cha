<?php


namespace App\Tables;

use Yii;

class ListingTableStructure extends AbstractTS
{
    public static function getTitles()
    {
        return [
          self::GROUP_CUSTOM => [
              self::ID => Yii::t('front', 'ID'),
              self::TITLE => Yii::t('front', 'TITLE'),
          ],
        ];
    }

    /**
     * Столбцы, по которым можно сортировать
     * @return array
     */
    public static function getSortedColumns()
    {
        return [
            self::ID,
            self::TITLE,
        ];
    }

}