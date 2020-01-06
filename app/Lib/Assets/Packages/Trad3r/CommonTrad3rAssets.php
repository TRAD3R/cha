<?php


namespace App\Assets\Packages\Trad3r;


use App\Assets\Packages\BootstrapAsset;
use App\Assets\Packages\BootstrapPluginAsset;
use App\Assets\Packages\CommonAsset;
use App\Assets\Packages\JuiAsset;
use yii\web\AssetBundle;

class CommonTrad3rAssets extends AssetBundle
{
    public $sourcePath = "@trad3r_resources";

    public $js = [
    ];

    public $css = [
    ];

    public $depends = [
        JuiAsset::class,
        CommonAsset::class,
//        BootstrapAsset::class,
//        BootstrapPluginAsset::class,
    ];
}