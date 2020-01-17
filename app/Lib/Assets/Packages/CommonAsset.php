<?php


namespace App\Assets\Packages;

use yii\web\AssetBundle;

class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common_resources';
    public $css = [
      'css/style.css',
    ];
    public $js = [
        'js/common.js'
    ];

}