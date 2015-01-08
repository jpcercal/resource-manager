<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceDataNotValidExceptionTest extends TestCase
{
    public function testExtendsResourceException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceDataNotValidException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceException'
        ));
    }
}
