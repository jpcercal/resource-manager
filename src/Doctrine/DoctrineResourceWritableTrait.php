<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Doctrine;

use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException;

/**
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
trait DoctrineResourceWritableTrait
{
    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceWritableInterface::writeResource
     */
    public function writeResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->persist($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedWriteException($e->getMessage());
        }
    }
}
