<?php

namespace Factories;

//snippet author-builder
class AuthorBuilder
{
    private Username $username;
    private Email $email;
    private FullName $fullName;

    private function __construct()
    {
        $this->username = new Username('johndoe');
        $this->email = new Email('john@doe.com');
        $this->fullName = new FullName('John', 'Doe');
    }

    public static function anAuthor(): self
    {
        return new self();
    }

    public function withFullName(FullName $aFullName): self
    {
        $this->fullName = $aFullName;

        return $this;
    }

    public function withUsername(Username $aUsername): self
    {
        $this->username = $aUsername;

        return $this;
    }

    public function withEmail(Email $anEmail): self
    {
        $this->email = $anEmail;

        return $this;
    }

    public function build(): Author
    {
        return new Author(
            $this->username,
            $this->fullName,
            $this->email
        );
    }
}
//end-snippet