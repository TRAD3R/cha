<?php


namespace tests\helpers;


class UserHelper
{
    public static function getWrong()
    {
        return [
            'email' => 'wrong@mail.ru',
            'password' => 123,
        ];
    }

    public static function getCorrect()
    {
        return [
            'email' => 'test@test.test',
            'password' => 123,
        ];
    }

}