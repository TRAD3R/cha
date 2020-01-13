<?php


namespace App\Repositories;

use App\Models\Swatch;

class SwatchRepository
{

  public static function getAllAsArray()
  {
    return Swatch::find()
      ->select('id, title')
      ->orderBy('title')
      ->asArray()
      ->all()
      ;
  }

    public static function findOneByValue($value)
    {
        return Swatch::find()
            ->where(['title' => $value])
            ->one()
            ;
    }
}