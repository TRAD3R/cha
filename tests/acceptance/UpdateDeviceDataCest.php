<?php

use tests\helpers\UserHelper;

class UpdateDeviceDataCest
{
    private function login(AcceptanceTester $I)
    {
        $user = UserHelper::getCorrect();

        $I->amOnPage('/login');
        $I->fillField('LoginForm[email]', $user['email']);
        $I->fillField('LoginForm[password]', $user['password']);
        $I->click('login');
    }
    public function _before(AcceptanceTester $I)
    {
    }
    
    public function wrongRequestGet(AcceptanceTester $I)
    {
        $this->login($I);
        $I->see(Yii::t('front', 'DATE_CREATED'));
        $I->sendAjaxGetRequest(['/device/10']);
        $I->seeResponseCodeIsClientError();
    }

    // tests
    public function updateDataTest(AcceptanceTester $I)
    {
        $this->login($I);
        $I->see(Yii::t('front', 'DATE_CREATED'));
        $I->sendAjaxPostRequest(['/device-update/587'], [
            
        ]);
    }
}
