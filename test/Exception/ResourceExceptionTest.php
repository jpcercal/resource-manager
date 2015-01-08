<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceExceptionTest extends TestCase
{
    public function testExtendsRuntimeException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\RuntimeException'
        ));
    }
}
