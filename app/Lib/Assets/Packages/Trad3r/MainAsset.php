<?php


namespace App\Assets\Packages\Trad3r;


use App\Assets\Packages\ChosenAsset;
use App\Assets\Packages\GadgetAsset;
use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';
    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/main.js',
    ];
    
    public $depends = [
        CommonTrad3rAssets::class,
        ChosenAsset::class,
        GadgetAsset::class,
    ];
}