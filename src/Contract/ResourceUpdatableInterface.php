<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Contract;

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException;

/**
 * ResourceUpdatable Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface ResourceUpdatableInterface extends ResourceInterface
{
    /**
     * Update a resource given the resource.
     *
     * @api
     *
     * @param  ResourceInterface $resource
     *
     * @return bool
     *
     * @throws ResourceManagerRefusedUpdateException
     */
    public function updateResource(ResourceInterface $resource);
}
