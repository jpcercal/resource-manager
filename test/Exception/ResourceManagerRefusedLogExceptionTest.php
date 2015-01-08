<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerRefusedLogExceptionTest extends TestCase
{
    public function testExtendsResourceManagerRefusedException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedLogException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedException'
        ));
    }
}
