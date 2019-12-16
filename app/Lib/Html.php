<?php


namespace App;


use Yii;

class Html extends \yii\helpers\Html
{

    private static $url_instances = [];

    /**
     * @param $name
     * @param $selection
     * @param $options
     * @return string
     */
    public static function boolDropDownList($name, $selection, $options = [])
    {
        return \yii\helpers\Html::dropDownList($name, $selection, [
            0 => Yii::t('front', 'DOES_NOT_HAVE'),
            1 => Yii::t('front', 'HAVE'),
        ], $options);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function getCsrfField()
    {
        return \yii\helpers\Html::hiddenInput(App::i()->getRequest()->getCsrfParam(), App::i()->getRequest()->getCsrf());
    }

    /**
     * @param $selected
     * @return string
     */
    public static function renderSlider($selected)
    {
        return App::i()->getController()->getView()->render('/navigation/slider', ['selected' => $selected]);
    }

    /**
     * @param bool $fast
     * @return string
     */
    public static function renderReload($fast = false)
    {
        return App::i()->getController()->getView()->renderFile('@layouts' . '/common/sevenoffers/reload.php', ['fast' => $fast]);
    }

    /**
     * @param array $params
     * @return string
     */
    public static function renderPaginator($params = [])
    {
        return App::i()->getController()->getView()->renderFile('@layouts' . '/common/paginator.php', $params);
    }
}