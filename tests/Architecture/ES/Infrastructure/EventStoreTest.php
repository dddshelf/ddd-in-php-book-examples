<?php

namespace Architecture\ES\Infrastructure;

use PHPUnit\Framework\TestCase;
use Zumba\JsonSerializer\JsonSerializer;

use Predis\Client;

use Architecture\CQRS\Domain\{
    PostId,
    CategoryId,
    PostWasCreated,
    PostWasPublished,
    PostWasCategorized,
    PostTitleWasChanged,
    PostContentWasChanged
};

use Architecture\ES\Domain\EventStream;

class EventStoreTest extends TestCase
{
    private EventStore $eventStore;

    public function setUp(): void
    {
        $this->eventStore = new EventStore(
            $client = new Client(),
            $serializer = new JsonSerializer()
        );
    }

    /**
     * @test
     */
    public function itShouldSaveAnRestoreAnEventStream(): void
    {
        $postId = PostId::create();
        $categoryId = CategoryId::create();

        $stream = new EventStream($postId->id(), [
            new PostWasCreated($postId, 'A title', 'Some content'),
            new PostWasPublished($postId),
            new PostWasCategorized($postId, $categoryId),
            new PostTitleWasChanged($postId, 'New title'),
            new PostContentWasChanged($postId, 'New content'),
        ]);

        $this->eventStore->append($stream);

        $foundStream = $this->eventStore->getEventsFor($postId->id());

        $this->assertEquals($foundStream, $stream);
    }
}