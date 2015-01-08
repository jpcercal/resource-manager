<?php

namespace Cekurte\ResourceManager\Test;

use Cekurte\ResourceManager\ResourceManager;
use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerTest extends TestCase
{
    public function dataProviderDoctrineResourceManagerDriverAsString()
    {
        return [
            ['doctrine'],
            ['Doctrine']
        ];
    }

    public function testCreateDoctrineResourceManagerUsingDriverAsDriverInterface()
    {
        $resourceManager = ResourceManager::create($this->getDoctrineDriver()->getMock());

        $this->assertInstanceOf(
            '\\Cekurte\\ResourceManager\\Service\\DoctrineResourceManager',
            $resourceManager
        );
    }

    /**
     * @dataProvider dataProviderDoctrineResourceManagerDriverAsString
     */
    public function testCreateDoctrineResourceManagerUsingDriverAsString($driverAsString)
    {
        $resourceManager = ResourceManager::create($driverAsString, [
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'FakeEntity',
        ]);

        $this->assertInstanceOf(
            '\\Cekurte\\ResourceManager\\Service\\DoctrineResourceManager',
            $resourceManager
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The driver "unknown" can not be found
     */
    public function testCreateDoctrineResourceManagerUsingDriverUnknownAsString()
    {
        ResourceManager::create('Unknown', [
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'FakeEntity',
        ]);
    }
}
