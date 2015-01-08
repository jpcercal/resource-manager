<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceDataExceptionTest extends TestCase
{
    public function testExtendsResourceException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceDataException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceException'
        ));
    }
}
