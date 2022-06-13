<?php

namespace Chapter6;

use DateTimeImmutable;

//snippet code
class UserRegistered implements DomainEvent
{
    private UserId $userId;
    private DateTimeImmutable $occurredOn;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
//end-snippet
