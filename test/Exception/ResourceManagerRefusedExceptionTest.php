<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerRefusedExceptionTest extends TestCase
{
    public function testExtendsResourceException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceException'
        ));
    }
}
