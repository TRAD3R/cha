<?php


namespace App\Assets\Packages\Trad3r;


use App\Assets\Packages\BootstrapAsset;
use App\Assets\Packages\BootstrapPluginAsset;
use App\Assets\Packages\CommonAsset;
use App\Assets\Packages\JuiAsset;
use yii\web\AssetBundle;

class ListingAssets extends AssetBundle
{
    public $sourcePath = "@trad3r_resources";

    public $js = [
      'js/main.js'
    ];

    public $css = [
      'css/style.css'
    ];

    public $depends = [
      CommonTrad3rAssets::class
    ];

}