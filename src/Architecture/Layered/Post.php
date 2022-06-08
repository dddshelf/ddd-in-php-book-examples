<?php

namespace Architecture\Layered;

//snippet post
class Post
{
    private ?int $id = null;
    private string $title;
    private string $content;

    public static function writeNewFrom(string $title, string $content): self
    {
        return new static($title, $content);
    }

    private function __construct(string $title, string $content)
    {
        $this->setTitle($title);
        $this->setContent($content);
    }

    private function setTitle(string $title): void
    {
        if (empty($title)) {
            throw new \RuntimeException('Title cannot be empty');
        }

        $this->title = $title;
    }

    private function setContent(string $content): void
    {
        if (empty($content)) {
            throw new \RuntimeException('Content cannot be empty');
        }

        $this->content = $content;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }
}
//end-snippet
