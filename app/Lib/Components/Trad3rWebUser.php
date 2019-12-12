<?php

namespace App\Components;


use App\Models\User;

class Trad3rWebUser extends WebUser
{

    /**
     * @param $identity
     * @param $cookieBased
     * @param $duration
     * @throws \Throwable
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        /** @var User $user */
        $user = $this->getIdentity();
        $user->updateAttributes(['date_last_visit' => date('Y-m-d H:i:s')]);
    }
}