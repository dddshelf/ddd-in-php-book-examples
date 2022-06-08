<?php

namespace Factories;

class Username
{
    private string $value;

    public function __construct(string $value) {
        $this->value = $value;
    }
}