<?php

namespace Architecture\Layered;

use PHPUnit\Framework\TestCase;

class PostServiceTest extends TestCase
{
    private $postService;

    public function setUp(): void
    {
        $this->db = new \PDO(
            'mysql:host=127.0.0.1;dbname=db', 'user', 'pass',
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );

        $this->postService = new PostService();
    }

    /**
     * @test
     */
    public function itShouldCreatePost(): void
    {
        $this->db->exec(<<<SQL
CREATE TABLE posts (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title TEXT NOT NULL,
  content TEXT NOT NULL
);
SQL
);

        $p = $this->postService->createPost('A title', 'Some content');

        $this->assertNotNull($p);

        $this->db->exec(<<<SQL
DROP TABLE posts
SQL
);
    }
}
