<?php

namespace Ddd\Auth\Infrastructure\Authentication;

use Ddd\Auth\Domain\Model\User\BaseSignIn;
use Ddd\Auth\Domain\Model\User\User;

class DefaultEncryptionSignIn extends BaseSignIn
{
    protected function isPasswordValidForUser(
        User $aUser,
        $anUnencryptedPassword
    ) {
        return password_verify($anUnencryptedPassword, $aUser->hash());
    }
}