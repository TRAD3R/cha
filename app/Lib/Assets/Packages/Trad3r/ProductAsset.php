<?php


namespace App\Assets\Packages\Trad3r;


use yii\web\AssetBundle;

class ProductAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';

    public $js = [
        'js/product.js',
        'js/search_models.js',
    ];
}