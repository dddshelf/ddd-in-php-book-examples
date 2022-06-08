<?php

namespace Architecture\CQRS\Infrastructure\Projection;

use PHPUnit\Framework\TestCase;

// use Architecture\CQRS\Domain\Post;

use Architecture\CQRS\Domain\{
    PostId,
    CategoryId,
    PostWasCreated,
    PostWasPublished,
    PostWasCategorized,
    PostTitleWasChanged,
    PostContentWasChanged
};
use Architecture\CQRS\Infrastructure\Projection\Elasticsearch\{
    PostWasCreatedProjection,
    PostWasPublishedProjection,
    PostWasCategorizedProjection,
    PostTitleWasChangedProjection,
    PostContentWasChangedProjection
};

class ProjectorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldProjectIntoElasticsearch()
    {
        //snippet projector-usage
        $client = \Elasticsearch\ClientBuilder::create()->build();

        $projector = new Projector();
        $projector->register([
            new PostWasCreatedProjection($client),
            new PostWasPublishedProjection($client),
            new PostWasCategorizedProjection($client),
            new PostTitleWasChangedProjection($client),
            new PostContentWasChangedProjection($client)
        ]);

        $postId = PostId::create();
        $categoryId = CategoryId::create();
        $projector->project([
            new PostWasCreated($postId, 'A title', 'Some content'),
            new PostWasPublished($postId),
            new PostWasCategorized($postId, $categoryId),
            new PostTitleWasChanged($postId, 'New title'),
            new PostContentWasChanged($postId, 'New content'),
        ]);
        //end-snippet

        $params = [
            'index' => 'posts',
            'type'  => 'post',
            'id'    => $postId->id()
        ];

        $document = $client->get($params);
        $this->assertEquals([
            'title' => 'New title',
            'content' => 'New content',
            'is_published' => true,
            'category_id' => $categoryId->id()
        ], $document['_source']);

        $client->delete($params);
        $client->indices()->delete(['index' => 'posts']);
    }
}
