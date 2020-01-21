<?php


namespace App\Assets\Packages\Trad3r;


use yii\web\AssetBundle;

class DeviceAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';

    public $js = [
        'js/device.js',
        'js/search_models.js',
    ];
}