<?php

namespace Ddd\Domain\Model;

class Product
{
    protected $productId;
    protected $name;
    protected $price;

    protected $surrogateCurrency;
    protected $surrogateAmount;

    public function __construct($aProductId, $aName, Money $aPrice)
    {
        $this->setProductId($aProductId);
        $this->setName($aName);
        $this->setPrice($aPrice);
    }

    private function setProductId($aProductId)
    {
        $this->productId = $aProductId;
    }

    private function setName($aName)
    {
        $this->name = $aName;
    }

    private function setPrice(Money $aMoney)
    {
        $this->price = $aMoney;
        $this->surrogateAmount = $aMoney->amount();
        $this->surrogateCurrency = $aMoney->currency()->isoCode();
    }

    public function id()
    {
        return $this->productId;
    }

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        if (null === $this->price) {
            $this->price = new Money(
                $this->surrogateAmount,
                new Currency($this->surrogateCurrency)
            );
        }

        return $this->price;
    }
}
