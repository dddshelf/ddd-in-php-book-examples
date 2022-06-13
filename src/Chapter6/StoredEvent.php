<?php

namespace Chapter6;

use DateTimeImmutable;

//snippet code
class StoredEvent implements DomainEvent
{
    private int $eventId;
    private string $typeName;
    private DateTimeImmutable $occurredOn;
    private string $eventBody;

    public function __construct(
        string $aTypeName,
        DateTimeImmutable $anOccurredOn,
        string $anEventBody
    )
    {
        $this->eventBody = $anEventBody;
        $this->typeName = $aTypeName;
        $this->occurredOn = $anOccurredOn;
    }

    public function eventId(): int
    {
        return $this->eventId;
    }

    public function typeName(): string
    {
        return $this->typeName;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventBody(): string
    {
        return $this->eventBody;
    }
}
//end-snippet
