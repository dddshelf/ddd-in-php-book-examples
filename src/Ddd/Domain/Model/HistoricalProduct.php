<?php

namespace Ddd\Domain\Model;

class HistoricalProduct extends Product
{
    /**
     * @var Money[]
     */
    protected $prices;

    public function __construct($aProductId, $aName, Money $aPrice, $somePrices)
    {
        parent::__construct($aProductId, $aName, $aPrice);
        $this->setPrices($somePrices);
    }

    private function setPrices($somePrices)
    {
        $this->prices = $somePrices;
    }

    public function addPrice($aPrice)
    {
        $this->prices[] = $aPrice;
    }

    public function prices()
    {
        return $this->prices;
    }
}
