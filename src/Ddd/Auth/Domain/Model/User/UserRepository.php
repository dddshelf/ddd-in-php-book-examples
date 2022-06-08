<?php

namespace Ddd\Auth\Domain\Model\User;

interface UserRepository
{
    public function add(User $aUser);
    public function byUsername($aUsername);
    public function has($aUsername);
}