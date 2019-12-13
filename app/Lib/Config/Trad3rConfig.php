<?php


namespace App\Config;


use App\App;
use App\Assets\AssetHelper;
use App\Assets\Packages\Trad3r\CommonTrad3rAssets;
use App\Assets\Packages\Trad3r\MainAsset;

class Trad3rConfig extends Config
{
    public function getNoReplyEmail()
    {
        return 'info@cha.de';
    }

    public function getAdminBaseUrl()
    {
        return "/admin";
    }

    public function getProjectLanguage()
    {
        return App::PROJECT_LANGUAGE_RU;
    }

    public function getDefaultTimeZone()
    {
        return "Europe/Moscow";
    }

    public function getCookieKey()
    {
        return 'cha_key';
    }

    public function getClientScriptConfig()
    {
        $client_script_confog = [
            // Общие скрипты для всех модулей
            AssetHelper::COMMON_PART => [
                CommonTrad3rAssets::class
            ],
            App::CONFIG_MODULE_MAIN => [
                AssetHelper::BUNDLES => [
                    MainAsset::class
                ],
                AssetHelper::CONTROLLERS => [
                    'site' => [
                        'index' => []
                    ],
                    'auth' => [
                        'login' => []
                    ]
                ]
            ]
        ];

        return $client_script_confog;
    }
}