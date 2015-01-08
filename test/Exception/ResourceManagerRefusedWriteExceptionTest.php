<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerRefusedWriteExceptionTest extends TestCase
{
    public function testExtendsResourceManagerRefusedException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedWriteException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedException'
        ));
    }
}
