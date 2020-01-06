<?php


namespace App\Assets\Packages;

use yii\web\AssetBundle;

class GadgetAsset extends AssetBundle
{
    public $sourcePath = '@trad3r_resources';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/Gadget.js'
    ];
    
    
}