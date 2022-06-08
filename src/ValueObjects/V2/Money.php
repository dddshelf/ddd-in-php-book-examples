<?php

namespace ValueObjects\V2;

//snippet money
class Money
{
    //ignore
    private int $amount;
    private Currency $currency;

    public static function fromAmountAndCurrency(int $anAmount, Currency $aCurrency): self
    {
        return new self(
            $anAmount,
            $aCurrency
        );
    }

    private function __construct(int $anAmount, Currency $aCurrency)
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

    public static function fromMoney(self $aMoney): self
    {
        return new self(
            $aMoney->amount(),
            $aMoney->currency()
        );
    }

    public static function fromCurrency(Currency $aCurrency): self
    {
        return new self(0, $aCurrency);
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
    //end-ignore

    public function increaseAmountBy(int $anAmount): self
    {
        return new self(
            $this->amount() + $anAmount,
            $this->currency()
        );
    }
}
//end-snippet
