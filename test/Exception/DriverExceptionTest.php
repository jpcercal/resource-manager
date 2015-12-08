<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class DriverExceptionTest extends TestCase
{
    public function testExtendsRuntimeException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\DriverException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\RuntimeException'
        ));
    }
}
