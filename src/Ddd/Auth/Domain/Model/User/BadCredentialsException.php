<?php

namespace Ddd\Auth\Domain\Model\User;

use Exception;

class BadCredentialsException extends Exception
{
    public function __construct(User $aUser, $aPassword)
    {
        parent::__construct(
            sprintf(
                'The password verification failed for user "%s" and the given password "%s"',
                $aUser->username(),
                $aPassword
            )
        );
    }
}