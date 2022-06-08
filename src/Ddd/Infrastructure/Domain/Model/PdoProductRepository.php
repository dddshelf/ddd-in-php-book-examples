<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Product;
use Ddd\Domain\Model\ProductRepository;
use Doctrine\ORM\EntityRepository;

class PdoProductRepository implements ProductRepository
{
    public function add(Product $aProduct)
    {
        $this->getEntityManager()->persist($aProduct);
        $this->getEntityManager()->flush($aProduct);
    }

    public function find($aProductId)
    {
        // TODO: Implement find() method.
    }
}
