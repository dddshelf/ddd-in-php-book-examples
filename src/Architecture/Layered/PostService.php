<?php

namespace Architecture\Layered;

//snippet post-service
class PostService
{
    public function createPost(string $title, string $content): Post
    {
        $post = Post::writeNewFrom($title, $content);

        (new PostRepository())->add($post);

        return $post;
    }
}
//end-snippet
