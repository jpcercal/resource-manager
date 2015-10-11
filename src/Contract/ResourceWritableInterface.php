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

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException;

/**
 * ResourceWritable Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface ResourceWritableInterface extends ResourceInterface
{
    /**
     * Write a resource given the resource.
     *
     * @api
     *
     * @param  ResourceInterface $resource
     *
     * @return bool
     *
     * @throws ResourceManagerRefusedWriteException
     */
    public function writeResource(ResourceInterface $resource);
}
