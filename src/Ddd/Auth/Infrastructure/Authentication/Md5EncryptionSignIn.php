<?php

namespace Ddd\Auth\Infrastructure\Authentication;

use Ddd\Auth\Domain\Model\User\BaseSignIn;
use Ddd\Auth\Domain\Model\User\User;

class Md5EncryptionSignIn extends BaseSignIn
{
    const SALT = 'S0m3S4lT';

    private function salt()
    {
        return md5(self::SALT);
    }

    protected function isPasswordValidForUser(
        User $aUser,
        $anUnencryptedPassword
    ) {
        return $aUser->hash() === md5($anUnencryptedPassword . '_' . $this->salt());
    }
}