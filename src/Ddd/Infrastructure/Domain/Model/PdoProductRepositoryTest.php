<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Currency;
use Ddd\Domain\Model\HistoricalProduct;
use Ddd\Domain\Model\Money;
use Ddd\Domain\Model\MoneyTimeable;

class PdoProductRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $repository;

    protected function setUp()
    {
        $this->repository = new PdoHistoricalProductRepository();
    }
}
