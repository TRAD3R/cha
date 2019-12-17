<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_WARNING);
// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined("BASE_PATH") or define("BASE_PATH", dirname(__DIR__) . '/app/Modules/Main/Trad3r');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require (dirname(__DIR__) . '/app/config/bootstrap.php');

defined("PROJECT_ID") or define("PROJECT_ID", \App\App::PROJECT_ID_TRAD3R);

//$config = require __DIR__ . '/../config/web.php';
$mainConfig = \App\App::i()->buildConfig(\App\App::CONFIG_MODULE_MAIN);
$testConfig = require dirname(__DIR__) . '/app/config/modules/test.php';
$config = array_merge($mainConfig, $testConfig);

(new yii\web\Application($config))->run();
