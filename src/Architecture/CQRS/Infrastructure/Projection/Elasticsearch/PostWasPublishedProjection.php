<?php

namespace Architecture\CQRS\Infrastructure\Projection\Elasticsearch;

use Elasticsearch\Client;
use Architecture\CQRS\Domain\{
    Projection,
    DomainEvent,
    PostWasPublished
};

class PostWasPublishedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listensTo(): string
    {
        return PostWasPublished::class;
    }

    public function project(DomainEvent $event): void
    {
        /** @var PostWasPublished $event */
        $id = $event->postId()->id();

        $this->client->update([
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $id,
            'body'  => ['doc' => [
                'is_published' => true
            ]]
        ]);
    }
}
