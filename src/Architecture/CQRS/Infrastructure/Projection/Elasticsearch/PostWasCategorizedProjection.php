<?php

namespace Architecture\CQRS\Infrastructure\Projection\Elasticsearch;

use Elasticsearch\Client;
use Architecture\CQRS\Domain\{
    Projection,
    DomainEvent,
    PostWasCategorized
};

class PostWasCategorizedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listensTo(): string
    {
        return PostWasCategorized::class;
    }

    public function project(DomainEvent $event): void
    {
        /** @var PostWasCategorized $event */
        $id = $event->postId()->id();

        $this->client->update([
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $id,
            'body'  => ['doc' => [
                'category_id' => $event->categoryId()->id()
            ]]
        ]);
    }
}
