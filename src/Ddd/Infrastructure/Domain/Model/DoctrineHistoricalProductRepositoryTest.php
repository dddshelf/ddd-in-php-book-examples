<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Currency;
use Ddd\Domain\Model\HistoricalProduct;
use Ddd\Domain\Model\HistoricalProductPrice;
use Ddd\Domain\Model\Money;
use Ddd\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Doctrine\ORM\Tools\SchemaTool;

class DoctrineHistoricalProductRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $em;
    private $tool;
    private $classes;
    private $productRepository;

    protected function setUp()
    {
        $this->em = (new EntityManagerFactory)->buildTest();

        $this->tool = new SchemaTool($this->em);
        $this->classes = array(
            $this->em->getClassMetadata('Ddd\\Domain\\Model\\HistoricalProduct'),
            $this->em->getClassMetadata('Ddd\\Domain\\Model\\Money')
        );

        $this->tool->dropSchema($this->classes);
        $this->tool->createSchema($this->classes);

        $this->productRepository = $this->em->getRepository('Ddd\\Domain\\Model\\HistoricalProduct');
    }

    /**
     * @test
     */
    public function createSaveAndFetchAProductWithDifferentPrices()
    {
        $price = new Money(999, new Currency('USD'));
        $otherPrices = [
            new Money(813, new Currency('EUR'))
        ];

        $id = 1;
        $name = 'Domain-Driven Design in PHP';
        $product = new HistoricalProduct(
            $id,
            $name,
            $price,
            $otherPrices
        );

        $this->productRepository->add($product);
        $product = $this->productRepository->find(1);

        $this->assertSame($id, $product->id());
        $this->assertSame($name, $product->name());
        $this->assertTrue($product->price()->equals($price));
        $this->assertCount(1, $product->prices());
        $this->assertTrue($product->prices()[0]->equals($otherPrices[0]));
    }

    protected function tearDown()
    {
        $this->tool->dropSchema($this->classes);
    }
}
