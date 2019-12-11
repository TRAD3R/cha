<?php

namespace App\Components;

use App\App;
use App\Models\CpaUser;
use yii\web\IdentityInterface;
use yii\web\User;

class WebUser extends User
{
    /**
     * @param IdentityInterface $identity
     * @param bool              $cookieBased
     * @param int               $duration
     * @throws \Throwable
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        /** @var CpaUser $user */
        $user = $this->getIdentity();
        $user->updateAttributes(['date_last_visit' => date('Y-m-d H:i:s')]);
    }
}