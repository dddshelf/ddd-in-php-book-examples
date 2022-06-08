<?php

namespace Architecture\CQRS\Infrastructure\Projection\Elasticsearch;

use Elasticsearch\Client;
use Architecture\CQRS\Domain\{
    Projection,
    DomainEvent,
    PostWasCreated
};

//snippet elasticsearch-projection
class PostWasCreatedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listensTo(): string
    {
        return PostWasCreated::class;
    }

    public function project(DomainEvent $event): void
    {
        /** @var PostWasCreated $event */
        $id = $event->postId()->id();

        $this->client->index([
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $id,
            'body'  => [
                'title' => $event->title(),
                'content' => $event->content()
            ]
        ]);
    }
}
//end-snippet
