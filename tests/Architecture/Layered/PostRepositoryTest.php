<?php

namespace Architecture\Layered;

use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    private $db;
    private $postRepository;

    public function setUp(): void
    {
        $this->db = new \PDO(
            'mysql:host=127.0.0.1;dbname=db', 'user', 'pass',
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );

        $this->postRepository = new PostRepository();
    }

    /**
     * @test
     */
    public function itShouldAddPost(): void
    {
        $this->db->exec(<<<SQL
CREATE TABLE posts (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title TEXT NOT NULL,
  content TEXT NOT NULL
);
SQL
);

        $p = Post::writeNewFrom('A title', 'Some content');

        $this->postRepository->add($p);

        $this->assertNotNull($p->id());

        $this->db->exec(<<<SQL
DROP TABLE posts
SQL
);
    }
}
