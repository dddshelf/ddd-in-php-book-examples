<?php

namespace Ddd\Infrastructure\Persistence\Doctrine;

use Ddd\Infrastructure\Persistence\Doctrine\Type\CustomSerializationMoneyType;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function build()
    {
        Type::addType(
            CustomSerializationMoneyType::CUSTOM_SERIALIZATION_MONEY,
            'Ddd\\Infrastructure\\Persistence\\Doctrine\\Type\\CustomSerializationMoneyType'
        );

        return EntityManager::create(
            (new DbalConnectionFactory())->build(),
            Setup::createXMLMetadataConfiguration([__DIR__.'/config'], true)
        );
    }

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function buildTest()
    {
        /*
        Type::addType(
            CustomSerializationMoneyType::CUSTOM_SERIALIZATION_MONEY,
            'Ddd\\Infrastructure\\Persistence\\Doctrine\\Type\\CustomSerializationMoneyType'
        );
        */

        return EntityManager::create(
            (new DbalConnectionFactory())->buildTest(),
            Setup::createXMLMetadataConfiguration([__DIR__.'/config'], true)
        );
    }
}
