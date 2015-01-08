<?php

namespace Cekurte\ResourceManager\Test\Driver;

use Cekurte\ResourceManager\Driver\DoctrineDriver;
use Cekurte\ResourceManager\Test\TestCase;

class DoctrineDriverTest extends TestCase
{
    public function testExtendsArrayObject()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Driver\\DoctrineDriver'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\ArrayObject'
        ));
    }

    public function testImplementsDriverInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Driver\\DoctrineDriver'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Cekurte\\ResourceManager\\Contract\\DriverInterface'
        ));
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\DriverException
     * @expectedExceptionMessage The argument "em" can not be empty.
     */
    public function testConstructorExceptionRequiredArgs()
    {
        new DoctrineDriver();
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\DriverException
     * @expectedExceptionMessage The argument "em" must be a instance of Doctrine\ORM\EntityManagerInterface.
     */
    public function testConstructorExceptionRequiredArgsEmCannotBeAString()
    {
        new DoctrineDriver([
            'em' => 'EntityManager'
        ]);
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\DriverException
     * @expectedExceptionMessage The resource class name "entity" must be a string.
     */
    public function testConstructorExceptionRequiredArgsEntityMustBeAString()
    {
        new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => []
        ]);
    }

    /**
     * @expectedException Cekurte\ResourceManager\Exception\DriverException
     * @expectedExceptionMessage The resource class name "entity" could not be empty.
     */
    public function testConstructorExceptionRequiredArgsEntityCouldNotBeEmpty()
    {
        new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => ''
        ]);
    }

    public function testSuccessfullyWithDefaultsValuesToOptionalArguments()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
        ]);

        $methods = $driver->getEntityRepositorySearchableMethods();

        $this->assertEquals('findResource', $methods['find_resource']);

        $this->assertEquals('findResources', $methods['find_resources']);

        $this->assertEquals('\Gedmo\Loggable\Entity\LogEntry', $driver->getEntityRepositoryLoggableClass());
    }

    public function testSuccessfullyChangeArgumentsLoggableRepositoryClass()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
            'entity_repository_loggable_class' => 'FakeLoggableRepositoryClass',
        ]);

        $methods = $driver->getEntityRepositorySearchableMethods();

        $this->assertEquals('findResource', $methods['find_resource']);

        $this->assertEquals('findResources', $methods['find_resources']);

        $this->assertEquals('FakeLoggableRepositoryClass', $driver->getEntityRepositoryLoggableClass());
    }

    public function testSuccessfullyChangeArgumentsFindResource()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
            'entity_repository_searchable_method_find_resource' => 'muCustomFindResource',
        ]);

        $methods = $driver->getEntityRepositorySearchableMethods();

        $this->assertEquals('muCustomFindResource', $methods['find_resource']);

        $this->assertEquals('findResources', $methods['find_resources']);

        $this->assertEquals('\Gedmo\Loggable\Entity\LogEntry', $driver->getEntityRepositoryLoggableClass());
    }

    public function testSuccessfullyChangeArgumentsFindResources()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
            'entity_repository_searchable_method_find_resources' => 'muCustomFindResources',
        ]);

        $methods = $driver->getEntityRepositorySearchableMethods();

        $this->assertEquals('findResource', $methods['find_resource']);

        $this->assertEquals('muCustomFindResources', $methods['find_resources']);

        $this->assertEquals('\Gedmo\Loggable\Entity\LogEntry', $driver->getEntityRepositoryLoggableClass());
    }

    public function testGetDoctrineOrmEm()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
        ]);

        $this->assertInstanceOf(
            '\\Doctrine\\ORM\\EntityManagerInterface',
            $driver->getDoctrineOrmEm()
        );
    }

    public function testGetEntity()
    {
        $driver = new DoctrineDriver([
            'em'     => $this->getEntityManager()->getMock(),
            'entity' => 'Company\Project\Entity\FakeEntity',
        ]);

        $this->assertEquals(
            'Company\Project\Entity\FakeEntity',
            $driver->getEntityFqn()
        );

        $this->assertEquals('FakeEntity', $driver->getEntityClass());

        $this->assertEquals('f', $driver->getEntityAlias());
    }
}
