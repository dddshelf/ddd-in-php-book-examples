<?php

namespace ValueObjects\V0;

//snippet currency
class Currency
{
    private string $isoCode;

    public function __construct(string $anIsoCode)
    {
        $this->setIsoCode($anIsoCode);
    }

    private function setIsoCode(string $anIsoCode): void
    {
        if (!preg_match('/^[A-Z]{3}$/', $anIsoCode)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid ISO code', $anIsoCode)
            );
        }

        $this->isoCode = $anIsoCode;
    }

    public function isoCode(): string
    {
        return $this->isoCode;
    }
}
//end-snippet
