<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Currency;
use Ddd\Domain\Model\HistoricalProduct;
use Ddd\Domain\Model\Money;
use Ddd\Domain\Model\MoneyTimeable;
use Ddd\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Doctrine\ORM\Tools\SchemaTool;

class PdoHistoricalProductRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $em;
    private $tool;
    private $classes;

    protected function setUp()
    {
        $this->em = (new EntityManagerFactory)->buildTest();
        $this->tool = new SchemaTool($this->em);
        $this->classes = array(
            $this->em->getClassMetadata('Ddd\\Domain\\Model\\Product'),
            $this->em->getClassMetadata('Ddd\\Domain\\Model\\HistoricalProduct')
        );

        $this->tool->createSchema($this->classes);
        $this->repository = new PdoHistoricalProductRepository($this->em->getConnection());
    }

    /**
     * @atest
     */
    public function createSaveAndFetchAProductWithDifferentPrices()
    {
        $price = new Money(999, new Currency('USD'));
        $historicalPrices = [
            new MoneyTimeable(new Money(899, new Currency('USD')), new \DateTime()),
            new MoneyTimeable(new Money(799, new Currency('USD')), new \DateTime()),
            new MoneyTimeable(new Money(699, new Currency('USD')), new \DateTime())
        ];

        $id = 1;
        $name = 'Domain-Driven Design in PHP';
        $product = new HistoricalProduct(
            $id,
            $name,
            $price,
            $historicalPrices
        );
        $this->repository->add($product);

        $product = $this->repository->find(1);

        $this->assertSame($id, $product->id());
        $this->assertSame($name, $product->name());
        $this->assertTrue($product->price()->equals($price));
    }
}
