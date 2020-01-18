<?php


namespace App\Assets\Packages\Trad3r;


use yii\web\AssetBundle;

class ListingAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';

    public $js = [
        'js/listing.js',
    ];
}