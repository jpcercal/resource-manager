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
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedDeleteException;

/**
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
trait DoctrineResourceDeletableTrait
{
    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceDeletableInterface::deleteResource
     */
    public function deleteResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->remove($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedDeleteException($e->getMessage());
        }
    }
}
