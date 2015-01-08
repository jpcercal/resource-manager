<?php

namespace Cekurte\ResourceManager\Test\Service;

use Cekurte\ResourceManager\Driver\DoctrineDriver;
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

    public function dataProviderRepositoryMethod()
    {
        return [
            ['find_resource',  'findResource'],
            ['find_resources', 'findResources'],
        ];
    }

    /**
     * @dataProvider dataProviderRepositoryMethod
     */
    public function testGetQueryBuilder($methodKey, $methodName)
    {
        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $repository = $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods([$methodName])
            ->getMock()
        ;

        $repository
            ->expects($this->once())
            ->method($methodName)
            ->will($this->returnValue($queryBuilder))
        ;

        $em = $this->getEntityManager()
            ->setMethods(['getRepository'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $result = $this->invokeMethod($resourceManager, 'getQueryBuilder', [$methodKey]);

        $this->assertTrue($result instanceof \Doctrine\ORM\QueryBuilder);
    }

    /**
     * @dataProvider dataProviderRepositoryMethod
     *
     * @expectedException Cekurte\ResourceManager\Exception\ResourceException
     */
    public function testGetQueryBuilderIsNotAQueryBuilderInstance($methodKey, $methodName)
    {
        $repository = $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods([$methodName])
            ->getMock()
        ;

        $repository
            ->expects($this->once())
            ->method($methodName)
            ->will($this->returnValue('IsNotAQueryBuilderInstance'))
        ;

        $em = $this->getEntityManager()
            ->setMethods(['getRepository'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $this->invokeMethod($resourceManager, 'getQueryBuilder', [$methodKey]);
    }

    /**
     * @dataProvider dataProviderRepositoryMethod
     */
    public function testGetQueryBuilderUsingCreateQueryBuilderMethod($methodKey, $methodName)
    {
        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $repository = $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['createQueryBuilder'])
            ->getMock()
        ;

        $repository
            ->expects($this->once())
            ->method('createQueryBuilder')
            ->will($this->returnValue($queryBuilder))
        ;

        $em = $this->getEntityManager()
            ->setMethods(['getRepository'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $result = $this->invokeMethod($resourceManager, 'getQueryBuilder', [$methodKey]);

        $this->assertTrue($result instanceof \Doctrine\ORM\QueryBuilder);
    }

    public function testProcessQueue()
    {
        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $processor = $this
            ->getMockBuilder('\\Cekurte\\Resource\\Query\\Language\\Processor\\DoctrineOrmProcessor')
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock()
        ;

        $processor
            ->expects($this->once())
            ->method('process')
            ->will($this->returnValue($queryBuilder))
        ;

        $queue = $this->getMock(
            '\\Cekurte\\Resource\\Query\\Language\\ExprQueue'
        );

        $resourceManager = $this->getDoctrineResourceManager($this->getDoctrineDriver()->getMock())
            ->getMock()
        ;

        $result = $this->invokeMethod($resourceManager, 'processQueue', [$processor, $queue]);

        $this->assertTrue($result instanceof \Doctrine\ORM\QueryBuilder);
    }

    public function testGetLogEntries()
    {
        $repository = $this
            ->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['getLogEntries'])
            ->getMock()
        ;

        $repository
            ->expects($this->once())
            ->method('getLogEntries')
            ->will($this->returnValue('logEntries'))
        ;

        $em = $this->getEntityManager()
            ->setMethods(['getRepository'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $this->assertEquals('logEntries', $resourceManager->getLogEntries($resourceInterface));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\ResourceManagerRefusedLogException
     */
    public function testGetLogEntriesException()
    {
        $classMetadata = $this
            ->getMockBuilder('\\Doctrine\\ORM\\Mapping\\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $repository = new \Doctrine\ORM\EntityRepository(
            $this->getEntityManager()->getMock(),
            $classMetadata
        );

        $em = $this->getEntityManager()
            ->setMethods(['getRepository'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'                               => $em,
            'entity'                           => 'FakeEntity',
            'entity_repository_loggable_class' => 'FakeLoggableEntity'
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $resourceManager->getLogEntries($resourceInterface);
    }

    public function testFindResource()
    {
        $query = $this->getMockBuilder('\FakeQueryClass')
            ->disableOriginalConstructor()
            ->setMethods(['getSingleResult'])
            ->getMock()
        ;

        $query
            ->expects($this->once())
            ->method('getSingleResult')
            ->will($this->returnValue('singleResult'))
        ;

        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $queryBuilder
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query))
        ;

        $resourceManager = $this->getDoctrineResourceManager(new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'FakeEntity',
        ]))
        ->setMethods(['getQueryBuilder', 'processQueue'])
        ->getMock()
        ;

        $resourceManager
            ->expects($this->once())
            ->method('getQueryBuilder')
            ->will($this->returnValue($queryBuilder))
        ;

        $resourceManager
            ->expects($this->once())
            ->method('processQueue')
            ->will($this->returnValue(null))
        ;

        $queue = $this->getMock(
            '\\Cekurte\\Resource\\Query\\Language\\ExprQueue'
        );

        $this->assertEquals('singleResult', $resourceManager->findResource($queue));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\ResourceDataNotFoundException
     */
    public function testFindResourceException()
    {
        $query = $this->getMockBuilder('\FakeQueryClass')
            ->disableOriginalConstructor()
            ->setMethods(['getSingleResult'])
            ->getMock()
        ;

        $query
            ->expects($this->once())
            ->method('getSingleResult')
            ->will($this->returnCallback(function () {
                throw new \Doctrine\ORM\NoResultException();
            }))
        ;

        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $queryBuilder
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query))
        ;

        $resourceManager = $this->getDoctrineResourceManager(new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'FakeEntity',
        ]))
        ->setMethods(['getQueryBuilder', 'processQueue'])
        ->getMock()
        ;

        $resourceManager
            ->expects($this->once())
            ->method('getQueryBuilder')
            ->will($this->returnValue($queryBuilder))
        ;

        $resourceManager
            ->expects($this->once())
            ->method('processQueue')
            ->will($this->returnValue(null))
        ;

        $queue = $this->getMock(
            '\\Cekurte\\Resource\\Query\\Language\\ExprQueue'
        );

        $resourceManager->findResource($queue);
    }

    public function testFindResources()
    {
        $query = $this->getMockBuilder('\FakeQueryClass')
            ->disableOriginalConstructor()
            ->setMethods(['getResult'])
            ->getMock()
        ;

        $query
            ->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue('result'))
        ;

        $queryBuilder = $this->getMockBuilder('\\Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $queryBuilder
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query))
        ;

        $resourceManager = $this->getDoctrineResourceManager(new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'FakeEntity',
        ]))
        ->setMethods(['getQueryBuilder', 'processQueue'])
        ->getMock()
        ;

        $resourceManager
            ->expects($this->once())
            ->method('getQueryBuilder')
            ->will($this->returnValue($queryBuilder))
        ;

        $resourceManager
            ->expects($this->once())
            ->method('processQueue')
            ->will($this->returnValue(null))
        ;

        $queue = $this->getMock(
            '\\Cekurte\\Resource\\Query\\Language\\ExprQueue'
        );

        $this->assertEquals('result', $resourceManager->findResources($queue));
    }

    public function testWriteResource()
    {
        $em = $this->getEntityManager()
            ->setMethods(['persist', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $this->assertTrue($resourceManager->writeResource($resourceInterface));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException
     */
    public function testWriteResourceException()
    {
        $em = $this->getEntityManager()
            ->setMethods(['persist', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnCallback(function () {
                throw new \Exception();
            }))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $resourceManager->writeResource($resourceInterface);
    }

    public function testUpdateResource()
    {
        $em = $this->getEntityManager()
            ->setMethods(['persist', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $this->assertTrue($resourceManager->updateResource($resourceInterface));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException
     */
    public function testUpdateResourceException()
    {
        $em = $this->getEntityManager()
            ->setMethods(['persist', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnCallback(function () {
                throw new \Exception();
            }))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $resourceManager->updateResource($resourceInterface);
    }

    public function testDeleteResource()
    {
        $em = $this->getEntityManager()
            ->setMethods(['remove', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('remove')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $this->assertTrue($resourceManager->deleteResource($resourceInterface));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\ResourceManagerRefusedDeleteException
     */
    public function testDeleteResourceException()
    {
        $em = $this->getEntityManager()
            ->setMethods(['remove', 'flush'])
            ->getMock()
        ;

        $em
            ->expects($this->once())
            ->method('remove')
            ->will($this->returnValue(null))
        ;

        $em
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnCallback(function () {
                throw new \Exception();
            }))
        ;

        $resourceManager = new DoctrineResourceManager(new DoctrineDriver([
            'em'     => $em,
            'entity' => 'FakeEntity',
        ]));

        $resourceInterface = $this->getMock(
            '\\Cekurte\\ResourceManager\\Contract\\ResourceInterface'
        );

        $resourceManager->deleteResource($resourceInterface);
    }
}
