<?php

namespace ValueObjects\V3;

use ValueObjects\V2\Currency;
use ValueObjects\V3\Money;

use PHPUnit\Framework\TestCase;

//snippet side-effect-example
class Banking
{
    public function doSomething(): void
    {
        $aMoney = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));

        $this->otherMethod($aMoney); //mysterious call
        // ...
    }
}
//end-snippet

class MoneyTest extends TestCase
{
    private Money $price;

    /**
     * @test
     */
    function itShouldIncreaseTheAmount()
    {
        //snippet pricing-example
        $this->price = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));
        // ...
        $this->price = $this->price->increaseAmountBy(200);
        //end-snippet

        $this->assertEquals($this->price, Money::fromAmountAndCurrency(300, Currency::fromValue('USD')));
    }
}
