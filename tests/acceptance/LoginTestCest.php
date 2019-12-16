<?php

use tests\helpers\UserHelper;

class LoginTestCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    
    public function testCheckValidate(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->canSeeElement('#form-login');
        $I->fillField('LoginForm[email]', 'wrong@test.te');
        $I->click('login');
        $this->wait($I, 1);
        $I->canSee('Необходимо заполнить «пароль»');
    }

    // tests
    public function testFailedLogin(AcceptanceTester $I)
    {
        $user = UserHelper::getWrong();
        
        $I->amOnPage('/login');
        $I->canSeeElement('#form-login');
        $I->fillField('LoginForm[email]', $user['email']);
        $I->fillField('LoginForm[password]', $user['password']);
        $I->click('login');
        $this->wait($I, 1);
        $error = \Yii::t('exception', 'WRONG_EMAIL_OR_PASSWORD');
        $I->see($error);
    }

    // tests
    public function testSuccessLogin(AcceptanceTester $I)
    {
        $user = UserHelper::getCorrect();

        $I->amOnPage('/login');
        $I->canSeeElement('#form-login');
        $I->fillField('LoginForm[email]', $user['email']);
        $I->fillField('LoginForm[password]', $user['password']);
        $I->click('login');
        $this->wait($I, 1);
        $I->canSee(Yii::t('front', 'DATE_CREATED'));
    }
    
    private function wait(AcceptanceTester $I, int $duration)
    {
        if(method_exists($I, 'wait')) {
            $I->wait($duration);
        }
    }
}
