<?php

namespace Cekurte\ResourceManager\Test\Service;

use Cekurte\ResourceManager\Service\DoctrineResourceManager;
use Cekurte\ResourceManager\Test\TestCase;

class DoctrineResourceManagerTest extends TestCase
{
    public function testImplementsResourceManagerInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Service\\DoctrineResourceManager'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceManagerInterface'
        ));
    }

    public function testGetDriver()
    {
        $driver = $this->getDoctrineDriver()->getMock();

        $resourceManager = new DoctrineResourceManager($driver);

        $this->assertInstanceOf(
            '\\Cekurte\\ResourceManager\\Driver\\DoctrineDriver',
            $resourceManager->getDriver()
        );
    }
}
