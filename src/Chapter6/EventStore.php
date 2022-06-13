<?php

namespace Chapter6;

//snippet code
interface EventStore
{
    public function append(DomainEvent $aDomainEvent): void;

    public function allStoredEventsSince($anEventId): array;
}
//end-snippet
