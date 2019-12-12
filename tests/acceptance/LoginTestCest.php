<?php

use Page\LoginPage;

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
        $I->amOnPage('/login');
        $I->canSeeElement('#form-login');
        $I->fillField('LoginForm[email]', 'wrong@test.te');
        $I->fillField('LoginForm[password]', 'wrong');
        $I->click('login');
        $this->wait($I, 1);
        $error = \Yii::t('exception', 'WRONG_EMAIL_OR_PASSWORD');
        $I->see($error);
    }

    // tests
    public function testSuccessLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->canSeeElement('#form-login');
        $I->fillField('LoginForm[email]', 'tatusr@gmail.com');
        $I->fillField('LoginForm[password]', 123456);
        $I->click('login');
        $this->wait($I, 1);
        $I->canSeeElement('#tabs');
    }
    
    private function wait(AcceptanceTester $I, int $duration)
    {
        if(method_exists($I, 'wait')) {
            $I->wait($duration);
        }
    }
}
