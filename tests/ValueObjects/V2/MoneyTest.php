<?php

namespace ValueObjects\V2;

use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @test
     */
    function itShouldNotBeComparable()
    {
        ob_start();

        //snippet money-compare-usage
        $aMoney = Money::fromAmountAndCurrency(100, Currency::fromValue('USD'));
        $otherMoney = $aMoney->increaseAmountBy(100);

        var_dump($aMoney === $otherMoney);
        // bool(false)

        $aMoney = $aMoney->increaseAmountBy(100);
        var_dump($aMoney === $otherMoney);
        // bool(false)
        //end-snippet

        $this->assertEquals("bool(false)\nbool(false)\n", ob_get_flush());
    }

    /**
     * @test
     */
    function itShouldNotBeEquivalent()
    {
        ob_start();

        //snippet money-equality-usage
        $a = Currency::fromValue('USD');
        $b = Currency::fromValue('USD');

        var_dump($a == $b);  // bool(true)
        var_dump($a === $b); // bool(false)

        $c = Currency::fromValue('EUR');

        var_dump($a == $c);  // bool(false)
        var_dump($a === $c); // bool(false)
        //end-snippet

        $this->assertEquals("bool(true)\nbool(false)\nbool(false)\nbool(false)\n", ob_get_flush());
    }

    /**
     * @test
     */
    function itShouldTestValues()
    {
        ob_start();

        //snippet values-example
        $a = 10;
        $b = 10;
        var_dump($a == $b);
        // bool(true)
        var_dump($a === $b);
        // bool(true)
        $a = 20;
        var_dump($a);
        // int(20)
        $a = $a + 30;
        var_dump($a);
        // int(50)
        //end-snippet

        $this->assertEquals("bool(true)\nbool(true)\nint(20)\nint(50)\n", ob_get_flush());
    }
}
