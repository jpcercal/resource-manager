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

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedLogException;

/**
 * ResourceLoggable Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface ResourceLoggableInterface extends ResourceInterface
{
    /**
     * Get all logs entries given the resource.
     *
     * @api
     *
     * @param  ResourceInterface $resource
     *
     * @return array
     *
     * @throws ResourceManagerRefusedLogException
     */
    public function getLogEntries(ResourceInterface $resource);
}
