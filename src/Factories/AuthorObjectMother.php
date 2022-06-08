<?php

namespace Factories;

//snippet author-object-mother
class AuthorObjectMother
{
    public static function createOne(): Author
    {
        return new Author(
            new Username('johndoe'),
            new FullName('John', 'Doe'),
            new Email('john@doe.com')
        );
    }
}
//end-snippet