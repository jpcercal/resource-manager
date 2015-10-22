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
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException;

/**
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
trait DoctrineResourceUpdatableTrait
{
    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceUpdatableInterface::updateResource
     */
    public function updateResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->persist($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedUpdateException($e->getMessage());
        }
    }
}
