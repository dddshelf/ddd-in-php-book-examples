<?php

namespace Architecture\Layered;

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidPosts
     */
    public function itShouldNotCreatePost(string $title, string $content): void
    {
        $this->expectException(\RuntimeException::class);
        
        Post::writeNewFrom($title, $content);
    }

    public function invalidPosts(): array
    {
        return [
            ['', 'Some content'],
            ['A title', '']
        ];
    }

    /**
     * @test
     */
    public function itShouldCreatePost(): void
    {
        $this->assertNotNull(Post::writeNewFrom('A title', 'Some content'));
    }
}
