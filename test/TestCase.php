<?php

namespace Cekurte\ResourceManager\Test;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function getDoctrineDriver()
    {
        return $this
            ->getMockBuilder('\\Cekurte\\ResourceManager\\Driver\\DoctrineDriver')
            ->disableOriginalConstructor()
        ;
    }

    public function getEntityManager()
    {
        return $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityManagerInterface')
            ->disableOriginalConstructor()
        ;
    }
}
