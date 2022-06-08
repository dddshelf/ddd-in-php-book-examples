<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Product;
use Ddd\Domain\Model\ProductRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineProductRepository extends EntityRepository implements ProductRepository
{
    public function add(Product $aProduct)
    {
        $this->getEntityManager()->persist($aProduct);
        $this->getEntityManager()->flush($aProduct);
    }
}
