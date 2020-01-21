<?php

use App\Helpers\ListingHelper;
use Codeception\Specify;
use Codeception\Test\Unit;
use App\Models\User;

class ListingTest extends Unit
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
    public function testCreateListing()
    {
        $this->specify('Создание листинга амазон', function (){
            expect('Проверка наличия файла', ListingHelper::create([]));
        });
    }
}