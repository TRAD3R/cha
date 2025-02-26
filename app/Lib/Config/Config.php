<?php


namespace App\Config;


use App\App;

abstract class Config
{
    /**
     * @return string
     */
    abstract public function getNoReplyEmail();

    /**
     * @return string
     */
    public function getFaceDomain()
    {
        return App::i()->getApp()->params['domains']['main'];
    }

    /**
     * @return string
     */
    public function getStaticDomainTemplate()
    {
        return App::i()->getApp()->params['domains']['static'];
    }

    /**
     * @return string
     */
    abstract public function getAdminBaseUrl();

    /**
     * @return string
     */
    abstract public function getProjectLanguage();

    /**
     * @return string
     */
    abstract public function getDefaultTimeZone();

    /**
     * @return string
     */
    abstract public function getCookieKey();

    /**
     * @return array
     */
    abstract public function getClientScriptConfig();
}