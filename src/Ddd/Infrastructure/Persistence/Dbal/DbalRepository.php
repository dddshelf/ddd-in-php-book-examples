<?php

namespace Ddd\Infrastructure\Persistence\Dbal;

use Ddd\Infrastructure\Persistence\Doctrine\DbalConnectionFactory;
use Doctrine\DBAL\Connection;

class DbalRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct($connection = null)
    {
        $this->connection = $connection;
    }

    protected function connection()
    {
        if (null === $this->connection) {
            $this->connection = (new DbalConnectionFactory())->buildTest();
        }

        return $this->connection;
    }
}
