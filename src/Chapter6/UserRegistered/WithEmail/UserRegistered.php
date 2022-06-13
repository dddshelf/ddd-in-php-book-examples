<?php

namespace Chapter6\UserRegistered\WithEmail;

use Chapter6\DomainEvent;
use DateTimeImmutable;

//snippet code
class UserRegistered implements DomainEvent
{
    //ignore
    private UserId $userId;
    private DateTimeImmutable $occurredOn;
    //end-ignore
    private string $userEmail;

    public function __construct(UserId $userId, string $userEmail)
    {
        $this->userId = $userId;
        $this->userEmail = $userEmail;
        $this->occurredOn = new \DateTimeImmutable();
    }

    //ignore
    public function userId(): UserId
    {
        return $this->userId;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
    //end-ignore

    public function userEmail(): string
    {
        return $this->userEmail;
    }
}
//end-snippet
