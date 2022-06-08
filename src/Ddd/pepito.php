<?php

use Ddd\Domain\Model\Currency;
use Ddd\Domain\Model\Money;

require_once __DIR__ . '/../vendor/autoload.php';

$myMoney = new Money(
    999,
    new Currency('USD')
);

$serializer = JMS\Serializer\SerializerBuilder::create()->build();
$jsonData = $serializer->serialize($myMoney, 'json');
echo $jsonData;
