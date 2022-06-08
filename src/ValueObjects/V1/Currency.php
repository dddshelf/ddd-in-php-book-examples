<?php

namespace ValueObjects\V1;

//snippet currency
class Currency
{
    //ignore
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
    //end-ignore

    public function equals(self $currency): bool
    {
        return $currency->isoCode() === $this->isoCode();

        // You could also access directly
        // the $isoCode field if necessary
        // return $currency->isoCode === $this->isoCode;
    }
}
//end-snippet
