<?php

namespace Ddd\Infrastructure\Domain\Model;

use Ddd\Domain\Model\Product;
use Ddd\Domain\Model\ProductRepository;
use Ddd\Infrastructure\Persistence\Dbal\DbalRepository;

class PdoHistoricalProductRepository extends DbalRepository implements ProductRepository
{
    public function find($aProductId)
    {
        $data = $this->connection()->executeQuery('SELECT * FROM products WHERE id = ' . $aProductId);
        print_r($data->fetchAll());
    }

    public function add(Product $aProduct)
    {
        $this->connection()->beginTransaction();

        $sql = 'INSERT INTO products VALUES (?, ?, ?, ?)';
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue(1, $aProduct->id());
        $stmt->bindValue(2, $aProduct->name());
        $stmt->bindValue(3, $aProduct->price()->amount());
        $stmt->bindValue(4, $aProduct->price()->currency()->isoCode());
        $stmt->execute();

        foreach($aProduct->prices() as $price) {
            $stmt = $this->connection()->prepare('INSERT INTO prices VALUES (?, ?)');
            $stmt->bindValue('i', $price->amount());
            $stmt->bindValue('i', $aProduct->id());

            // ...

            $sql = 'INSERT INTO currencies VALUES (?, ?)';
            $stmt = $this->connection()->prepare($sql);
            $stmt->bind_param('i', $price);
            $stmt->bind_param('i', $aProduct->price()->amount());

            // ...
        }

        $data = $this->connection()->executeQuery('SELECT * FROM products');
        print_r($data->fetchAll());

        // ...
    }
}
