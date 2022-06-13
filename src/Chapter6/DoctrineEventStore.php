<?php

namespace Chapter6;

use Zumba\JsonSerializer\JsonSerializer;

//snippet code
class DoctrineEventStore extends EntityRepository implements EventStore
{
    private JsonSerializer $serializer;

    public function append(DomainEvent $aDomainEvent): void
    {
        $storedEvent = new StoredEvent(
            get_class($aDomainEvent),
            $aDomainEvent->occurredOn(),
            $this->serializer()->serialize($aDomainEvent)
        );

        $this->getEntityManager()->persist($storedEvent);
    }

    public function allStoredEventsSince($anEventId): array
    {
        $query = $this->createQueryBuilder('e');
        if ($anEventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameters(['eventId' => $anEventId]);
        }
        $query->orderBy('e.eventId');

        return $query->getQuery()->getResult();
    }

    private function serializer(): JsonSerializer
    {
        if (null === $this->serializer) {
            $this->serializer = new JsonSerializer();
        }

        return $this->serializer;
    }
}
//end-snippet
