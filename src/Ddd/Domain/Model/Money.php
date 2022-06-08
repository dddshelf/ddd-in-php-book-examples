<?php

namespace Ddd\Domain\Model;

class Money
{
    private $amount;
    private $currency;

    private $surrogateId;
    private $surrogateCurrencyIsoCode;

    public function __construct($amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    private function setAmount($amount)
    {
        $this->amount = $amount;
    }

    private function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
        $this->surrogateCurrencyIsoCode = $currency->isoCode();
    }

    public function currency()
    {
        return new Currency($this->surrogateCurrencyIsoCode);
    }

    public function amount()
    {
        return $this->amount;
    }

    public function equals(Money $aMoney)
    {
        return
            $this->amount() === $aMoney->amount()
            && $this->currency()->equals($this->currency());
    }
}
