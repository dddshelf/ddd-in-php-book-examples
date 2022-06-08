<?php

namespace Ddd\Auth\Domain\Model\User;

interface SignIn
{
    public function execute($aUsername, $aPassword);
}