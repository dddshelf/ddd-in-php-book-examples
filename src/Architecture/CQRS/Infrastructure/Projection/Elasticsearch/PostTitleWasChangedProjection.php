<?php

namespace Architecture\CQRS\Infrastructure\Projection\Elasticsearch;

use Elasticsearch\Client;
use Architecture\CQRS\Domain\{
    Projection,
    DomainEvent,
    PostTitleWasChanged
};

class PostTitleWasChangedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listensTo(): string
    {
        return PostTitleWasChanged::class;
    }

    public function project(DomainEvent $event): void
    {
        /** @var PostTitleWasChanged $event */
        $id = $event->postId()->id();

        $this->client->update([
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $id,
            'body'  => ['doc' => [
                'title' => $event->title()
            ]]
        ]);
    }
}
