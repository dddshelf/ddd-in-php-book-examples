<?php

namespace Ddd\Auth\Infrastructure\Persistence\InMemory;

use Ddd\Auth\Domain\Model\User\User;
use Ddd\Auth\Domain\Model\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    public function add(User $aUser)
    {
        $this->users[] = $aUser;
    }

    public function byUsername($aUsername)
    {
        $users = $this->filterByUsername($aUsername);

        if (count($users) > 0) {
            return array_shift($users);
        }
    }

    public function has($aUsername)
    {
        return count($this->filterByUsername($aUsername)) > 0;
    }

    private function filterByUsername($aUsername)
    {
        $users = array_filter(
            $this->users,
            function (User $aUser) use ($aUsername) {
                return $aUsername === $aUser->username();
            }
        );
        return $users;
    }
}