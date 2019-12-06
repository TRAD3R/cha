<?php
    return yii\helpers\ArrayHelper::merge(
        require dirname(__DIR__) . '/../app/config/modules/test.php',
        \App\App::i()->buildConfig(\App\App::CONFIG_MODULE_CONSOLE)
    );