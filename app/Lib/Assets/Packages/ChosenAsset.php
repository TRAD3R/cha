<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChosenAsset
 * @package App\Assets\Packages
 */
class ChosenAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@trad3r_resources';

    /** @var array */
    public $css = [
        'css/chosen.css',
    ];

    /** @var array */
    public $js = [
        'js/chosen.js',
    ];

    /** @var array */
    public $depends = [JqueryAsset::class];
}