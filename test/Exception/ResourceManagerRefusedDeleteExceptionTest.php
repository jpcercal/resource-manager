<?php

namespace Cekurte\ResourceManager\Test\Exception;

use Cekurte\ResourceManager\Test\TestCase;

class ResourceManagerRefusedDeleteExceptionTest extends TestCase
{
    public function testExtendsResourceManagerRefusedException()
    {
        $reflection = new \ReflectionClass(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedDeleteException'
        );

        $this->assertTrue($reflection->isSubclassOf(
            '\\Cekurte\\ResourceManager\\Exception\\ResourceManagerRefusedException'
        ));
    }
}
