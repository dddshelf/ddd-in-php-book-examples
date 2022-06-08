<?php

namespace Factories;

use PHPUnit\Framework\TestCase;

class AuthorBuildTest extends TestCase
{
    //snippet author-build-test
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
    //end-snippet

    //snippet author-object-mother-test
    /**
     * @test
     */
    public function itDoesAnotherThing()
    {
        $author = AuthorObjectMother::createOne();

        //do something with author
    }
    //end-snippet

    //snippet author-builder-test
    /**
     * @test
     */
    public function itDoesAnotherSomething()
    {
        $author = AuthorBuilder::anAuthor()
            ->withEmail(new Email('other@email.com'))
            ->build();

        //do something with author
    }
    //end-snippet
}