<?php
    return yii\helpers\ArrayHelper::merge(
        \App\App::i()->buildConfig(\App\App::CONFIG_MODULE_CONSOLE),
        require dirname(dirname(__DIR__)) . '/app/config/modules/test.php'
    );