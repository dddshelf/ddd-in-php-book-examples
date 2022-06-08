<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Currency;
use Ddd\Domain\Model\Money;
use Ddd\Domain\Model\Product;
use Ddd\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Doctrine\ORM\Tools\SchemaTool;

class DoctrineProductRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $em;
    private $tool;
    private $classes;

    protected function setUp()
    {
        $this->em = (new EntityManagerFactory)->buildTest();
        $this->tool = new SchemaTool($this->em);
        $this->classes = array(
            $this->em->getClassMetadata('Ddd\\Domain\\Model\\Product')
        );

        $this->tool->createSchema($this->classes);
    }

    /**
     * @test
     */
    public function createSaveAndFetchAProduct()
    {
        $repository = $this->em->getRepository('Ddd\\Domain\\Model\\Product');

        $price = new Money(999, new Currency('USD'));
        $id = 1;
        $name = 'Domain-Driven Design in PHP';
        $product = new Product(
            $id,
            $name,
            $price
        );
        $repository->add($product);

        $product = $repository->find(1);

        $this->assertSame($id, $product->id());
        $this->assertSame($name, $product->name());
        $this->assertTrue($product->price()->equals($price));
    }

    protected function tearDown()
    {
        $this->tool->dropSchema($this->classes);
    }
}
