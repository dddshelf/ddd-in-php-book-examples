<?php

namespace Ddd\Domain\Model;

class Currency
{
    private $isoCode;

    public function __construct($isoCode)
    {
        $this->setIsoCode($isoCode);
    }

    public function isoCode()
    {
        return $this->isoCode;
    }

    private function setIsoCode($isoCode)
    {
        if (!preg_match('/^[A-Z]{3}$/', $isoCode)) {
            throw new \InvalidArgumentException();
        }

        $this->isoCode = $isoCode;
    }

    public function equals(Currency $aCurrency)
    {
        return $this->isoCode() === $aCurrency->isoCode();
    }
}
