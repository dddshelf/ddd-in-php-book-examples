<?php

namespace ValueObjects\V3;

use ValueObjects\V1\Currency;

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

    public static function fromMoney(Money $aMoney): self
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

    public function increaseAmountBy(int $anAmount): Money
    {
        return new self(
            $this->amount() + $anAmount,
            $this->currency()
        );
    }

    public function equals(self $money): bool
    {
        return
            $money->currency()->equals($this->currency()) &&
            $money->amount() === $this->amount();
    }
    //end-ignore

    public function add(self $aMoney): self
    {
        if (!$aMoney->currency()->equals($this->currency())) {
            throw new \InvalidArgumentException(
                'Currencies do not match'
            );
        }

        $this->amount += $aMoney->amount();
    }
}
//end-snippet
