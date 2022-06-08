<?php

namespace Architecture\ES\Infrastructure\V0;

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

use Architecture\ES\Domain\{EventStream, Post};
use Architecture\ES\Infrastructure\{EventStore, SnapshotRepository};
use Architecture\CQRS\Infrastructure\Projection\Projector;

class EventStorePostRepositoryTest extends TestCase
{
    private EventStore $eventStore;

    public function setUp(): void
    {
        $this->postRepository = new EventStorePostRepository(
            $eventStore = new EventStore(
                $client = new Client(),
                $serializer = new JsonSerializer()
            ),
            $projector = new Projector()
        );
    }

    /**
     * @test
     */
    public function itShouldSaveAnRestoreAnEventStream(): void
    {
        $p = Post::writeNewFrom('A title', 'Some content');

        $this->postRepository->save($p);

        $this->assertPostCreated($p->id(), 'A title', 'Some content');
    }

    private function assertPostCreated(PostId $id, string $title, string $content): void
    {
        $found = $this->postRepository->byId($id);
        $this->assertEquals($title, $found->title());
        $this->assertEquals($content, $found->content());
    }
}