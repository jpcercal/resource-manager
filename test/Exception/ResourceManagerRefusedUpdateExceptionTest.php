<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerRefusedUpdateExceptionTest extends TestCase
{
    public function testExtendsResourceManagerRefusedException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedUpdateException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedException'
        ));
    }
}
