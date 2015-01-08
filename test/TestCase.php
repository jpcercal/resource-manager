<?php

namespace Cekurte\ResourceManager\Test;

use Cekurte\ResourceManager\Driver\DoctrineDriver;
use Cekurte\Tdd\ReflectionTestCase;

class TestCase extends ReflectionTestCase
{
    public function getDoctrineDriver()
    {
        return $this
            ->getMockBuilder('\\Cekurte\\ResourceManager\\Driver\\DoctrineDriver')
            ->disableOriginalConstructor()
        ;
    }

    public function getDoctrineResourceManager(DoctrineDriver $driver)
    {
        return $this
            ->getMockBuilder('\\Cekurte\\ResourceManager\\Service\\DoctrineResourceManager')
            ->enableOriginalConstructor()
            ->setConstructorArgs([$driver])
        ;
    }

    public function getEntityManager()
    {
        return $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityManager')
            ->disableOriginalConstructor()
        ;
    }
}
