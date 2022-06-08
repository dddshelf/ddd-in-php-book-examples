<?php

namespace ValueObjects\V0;

//snippet money
class Money
{
    private int $amount;
    private Currency $currency;

    public function __construct(int $anAmount, Currency $aCurrency)
    {
        $this->setAmount($anAmount);
        $this->setCurrency($aCurrency);
    }

    private function setAmount($anAmount): void
    {
        $this->amount = (int) $anAmount;
    }

    private function setCurrency(Currency $aCurrency): void
    {
        $this->currency = $aCurrency;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
//end-snippet
