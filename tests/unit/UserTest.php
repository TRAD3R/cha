<?php

use Codeception\Specify;
use Codeception\Test\Unit;
use App\Models\User;

class UserTest extends Unit
{
    /**
     * Specify используется для возможности объединения разных тестов в 1 метод.
     * При этом все тесты вызываются отдельно, т.е. используются всегда исходные значения
     */
    use Specify;
    
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    /** @var User */
    private $user;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidation()
    {
        $this->specify('Проверка обязательных полей', function (){
            $this->user->email = null;

            expect('Проверка пустоты email и хеш-пароль', $this->user->validate())->false();
            expect('Проверка пустоты email', $this->user->getErrors())->hasKey('email');
            expect('Проверка отсутсвия хеш-пароля', $this->user->getErrors())->hasKey('password_hash');
        });

        $this->specify('Проверка полей на неправильные значения', function (){
            $this->user->email = 'test';
            $this->user->password_hash = '';
            expect('Проверка наличия ошибок email и хеш-пароль', $this->user->validate())->false();
            expect('Проверка неправильных данных email', $this->user->getErrors())->hasKey('email');
            expect('Проверка пустоты хеш-пароля', $this->user->getErrors())->hasKey('password_hash');
        });

        $this->specify('Проверка email на уникальность', function (){
            $this->user->email = 'test@test.test';
            expect('Проверка наличия ошибок email и хеш-пароль', $this->user->validate())->false();
            expect('Проверка неправильных данных email', $this->user->getErrors())->hasKey('email');
            expect('Проверка пустоты хеш-пароля', $this->user->getErrors())->hasKey('password_hash');
        });

        $this->specify('Проверка полей на корректность', function (){
            $this->user->email = 'test@test.te';
            $this->user->setPasswordHash('1234');
            expect('Проверка отсутствия ошибок email и хеш-пароль', $this->user->validate())->true();
        });
    }
    
    public function testSaveIntoDatabase()
    {
        $this->specify('Проверка сохранения данных в базу', function (){
            $user = new User();
            $user->email = 'success@test.te';
            $user->setPasswordHash('1234');
            expect('Проверка успешности сохранения в базу', $user->save())->true();
        });
    }
}