<?php

namespace ValueObjects\V2;

//snippet currency-factory-method
class Currency
{
    private string $isoCode;

    public static function fromValue(string $anIsoCode): self
    {
        return new self($anIsoCode);
    }

    private function __construct(string $anIsoCode)
    {
        $this->setIsoCode($anIsoCode);
    }

    //ignore
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

    public function equals(self $aCurrency): bool
    {
        return $aCurrency->isoCode() === $this->isoCode();

        // You could also access directly
        // the $isoCode field if necessary
        // return $aCurrency->isoCode === $this->isoCode;
    }
    //end-ignore
}
//end-snippet
