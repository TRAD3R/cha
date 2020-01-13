<?php


namespace App\Repositories;


use App\Models\Swatch;

class SwatchRepository
{

  public static function getAllAsArray()
  {
    return Swatch::find()
      ->select('id, name as title')
      ->orderBy('title')
      ->asArray()
      ->all()
      ;
  }
}