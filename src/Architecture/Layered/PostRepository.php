<?php

namespace Architecture\Layered;

class UnableToCreatePostException extends \RuntimeException {}

//snippet post-repository
class PostRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = new \PDO(
            'mysql:host=127.0.0.1;dbname=db', 'user', 'pass',
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function add(Post $post): void
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare(
                'INSERT INTO posts (title, content) VALUES (?, ?)'
            );

            $stmt->execute([
                $post->title(),
                $post->content(),
            ]);

            $this->db->commit();

            $post->setId((int) $this->db->lastInsertId());
        } catch (\Exception $e) {
            $this->db->rollback();
            throw new UnableToCreatePostException($e->getMessage());
        }
    }
}
//end-snippet
