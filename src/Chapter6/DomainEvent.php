<?php

namespace Chapter6;

//snippet code
interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
//end-snippet
