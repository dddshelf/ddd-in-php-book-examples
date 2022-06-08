<?php

namespace Architecture\CQRS\Infrastructure\Projection\Elasticsearch;

use Elasticsearch\Client;
use Architecture\CQRS\Domain\{
    Projection,
    DomainEvent,
    PostContentWasChanged
};

class PostContentWasChangedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listensTo(): string
    {
        return PostContentWasChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        /** @var PostContentWasChanged $event */
        $id = $event->postId()->id();
        
        $this->client->update([
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $id,
            'body'  => ['doc' => [
                'content' => $event->content()
            ]]
        ]);
    }
}
