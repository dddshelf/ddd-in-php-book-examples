<?php

namespace Ddd\Auth\Infrastructure\Authentication;

use Ddd\Auth\Domain\Model\User\BaseSignIn;
use Ddd\Auth\Domain\Model\User\User;

class NoEncryptionSignIn extends BaseSignIn
{
    protected function isPasswordValidForUser(
        User $aUser,
        $aPassword
    ) {
        return $aPassword === $aUser->hash();
    }
}