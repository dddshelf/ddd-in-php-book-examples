<?php

namespace Ddd\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\DriverManager;

class DbalConnectionFactory
{
    public function build()
    {
        return DriverManager::getConnection(
            array(
                'driver'   => 'pdo_mysql',
                'host' => 'localhost',
                'user'     => 'root',
                'password' => '',
                'dbname'   => 'ddd',
            )
        );
    }

    public function buildTest()
    {
        return DriverManager::getConnection(
            array(
                'driver'   => 'pdo_sqlite',
                'memory'   => true,
                'dbname'   => 'ddd',
            )
        );
    }
}
