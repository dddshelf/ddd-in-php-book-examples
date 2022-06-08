<?php

class PostId
{
}

class Username
{
    public function __construct($username) {}
}

class FullName
{
    public function __construct($firstName, $lastName) {}
}

class Email
{
    public function __construct($email) {}
}

class Body
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function equals(Body $body)
    {
        return $this->content === $body->content;
    }
}

class Author
{
    private $username;
    private $email;
    private $fullName;

    public function __construct(
        Username $aUsername,
        FullName $aFullName,
        Email $anEmail
    ) {
        $this->username = $aUsername;
        $this->email = $anEmail;
        $this->fullName = $aFullName;
    }
}

class AuthorBuilder
{
    private $username;
    private $email;
    private $fullName;

    private function __construct()
    {
        $this->username = new Username('johndoe');
        $this->email = new Email('john@doe.com');
        $this->fullName = new FullName('John', 'Doe');
    }

    public static function anAuthor()
    {
        return new self();
    }

    public function withFullName(FullName $aFullName)
    {
        $this->fullName = $aFullName;

        return $this;
    }

    public function withUsername(Username $aUsername)
    {
        $this->username = $aUsername;

        return $this;
    }

    public function withEmail(Email $anEmail)
    {
        $this->email = $anEmail;

        return $this;
    }

    public function build()
    {
        return new Author($this->username, $this->fullName, $this->email);
    }
}

class PostBuilder
{
    private $postId;
    private $author;
    private $body;

    private function __construct()
    {
        $this->postId = new PostId();
        $this->author = AuthorBuilder::anAuthor()->build();
        $this->body = new Body('Post body');
    }

    public static function aPost()
    {
        return new self();
    }

    public function withAuthor(Author $anAuthor)
    {
        $this->author = $anAuthor;

        return $this;
    }

    public function withPostId(PostId $aPostId)
    {
        $this->postId = $aPostId;

        return $this;
    }

    public function withBody(Body $body)
    {
        $this->body = $body;

        return $this;
    }

    public function build()
    {
        return new Post($this->postId, $this->author, $this->body);
    }
}

class Post
{
    private $id;
    private $author;
    private $body;
    private $createdAt;

    public function __construct(
        PostId $anId,
        Author $anAuthor,
        Body $aBody)
    {
        $this->id = $anId;
        $this->author = $anAuthor;
        $this->body = $aBody;
        $this->createdAt = new DateTime();
    }
}


class MyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itDoesSomething()
    {
        $author = new Author(
            new Username('johndoe'),
            new FullName('John', 'Doe'),
            new Email('john@doe.com')
        );

        //do something with author
    }

    /**
     * @test
     */
    public function itDoesSomething2()
    {
        $author = AuthorObjectMother::createOne();

        //do something with author
    }

    /**
     * @test
     */
    public function itDoesSomething3()
    {
        $author = AuthorBuilder::anAuthor()
            ->withEmail(new Email('other@email.com'))
            ->build();

        //do something with author
    }

    /**
     * @test
     */
    public function itDoesSomething4()
    {
        $post = PostBuilder::aPost()
            ->withAuthor(AuthorBuilder::anAuthor()
                ->withUsername(new Username('other'))
                ->build())
            ->withBody(new Body('Another body'))
            ->build();

        //do something with the post
    }
}

class AuthorObjectMother
{
    public static function createOne()
    {
        return new Author(
            new Username('johndoe'),
            new FullName('John', 'Doe'),
            new Email('john@doe.com')
        );
    }

    //THIRD
    public static function createWithEmail(Email $email)
    {
        return new Post(
            new PostId(),
            new Author('name', $email),
            new Body('body')
        );
    }
}


class MyServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldSendAnEmail()
    {
        $this->repository->save(
            PostObjectMother::createWithEmail(new Email('user@example.com'))
        );

        $this->service->execute('user@example.com');

        // ...
    }
}
