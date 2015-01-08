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

use Cekurte\ResourceManager\Exception\ResourceDataNotFoundException;
use Cekurte\Resource\Query\Language\ExprQueue;

/**
 * ResourceSearchable Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface ResourceSearchableInterface extends ResourceInterface
{
    /**
     * Find a resource given the Query Expression.
     *
     * @api
     *
     * @param  ExprQueue $queue
     *
     * @return ResourceInterface
     *
     * @throws ResourceDataNotFoundException
     */
    public function findResource(ExprQueue $queue);

    /**
     * Find the resources given the Query Expression.
     *
     * @api
     *
     * @param  ExprQueue $queue
     *
     * @return array
     */
    public function findResources(ExprQueue $queue = null);
}
