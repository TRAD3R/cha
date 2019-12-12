<?php


namespace App\Assets\Packages\Trad3r;


use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';
    public $css = [
        'css/main.css'
    ];

    public $js = [
        'js/main.js'
    ];
    
    public $depends = [
        CommonTrad3rAssets::class
    ];
}