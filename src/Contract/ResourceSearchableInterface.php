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

use Cekurte\ResourceManager\Contract\QueryExprInterface;
use Cekurte\ResourceManager\Exception\ResourceDataNotFoundException;

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
     * @param  QueryExprInterface $queryExpr
     *
     * @return ResourceInterface
     *
     * @throws ResourceDataNotFoundException
     */
    public function findResource(QueryExprInterface $queryExpr);

    /**
     * Find the resources given the Query Expression.
     *
     * @api
     *
     * @param  QueryExprInterface $queryExpr
     *
     * @return array
     */
    public function findResources(QueryExprInterface $queryExpr = null);
}
