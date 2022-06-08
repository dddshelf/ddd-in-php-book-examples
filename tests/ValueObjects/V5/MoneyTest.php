<?php

namespace ValueObjects\V5;

use ValueObjects\V2\Currency;

use PHPUnit\Framework\TestCase;

//snippet money-test
class MoneyTest extends TestCase
{
    /**
     * @test
     */
    public function copiedMoneyShouldRepresentSameValue()
    {
        $aMoney = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));

        $copiedMoney = Money::fromMoney($aMoney);

        $this->assertTrue($aMoney->equals($copiedMoney));
    }

    /**
     * @test
     */
    public function originalMoneyShouldNotBeModifiedOnAddition()
    {
        $aMoney = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));
        $otherMoney = Money::fromAmountAndCurrency(20, Currency::fromValue('USD'));

        $aMoney->add($otherMoney);

        $this->assertEquals(100, $aMoney->amount());
    }

    /**
     * @test
     */
    public function moniesShouldBeAdded()
    {
        $aMoney = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));
        $otherMoney = Money::fromAmountAndCurrency(20, Currency::fromValue('USD'));

        $newMoney = $aMoney->add($otherMoney);

        $this->assertEquals(120, $newMoney->amount());
    }

    // ...
}
//end-snippet
