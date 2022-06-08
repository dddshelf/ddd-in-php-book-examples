<?php

namespace Ddd\Domain\Model;

use Ddd\Domain\DomainEvent;

class UserRegistered implements DomainEvent
{
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
        $this->occurredOn = new \DateTime();
    }

    public function userId()
    {
        return $this->userId;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
