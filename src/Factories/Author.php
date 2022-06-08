<?php

namespace Factories;

//snippet author
class Author
{
    private Username $username;
    private FullName $fullName;
    private Email $email;

    public function __construct(
        Username $aUsername,
        FullName $aFullName,
        Email $anEmail
    ) {
        $this->username = $aUsername;
        $this->fullName = $aFullName;
        $this->email = $anEmail;
    }

    // ...
}
//end-snippet