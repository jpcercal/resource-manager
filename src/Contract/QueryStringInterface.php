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
use Psr\Http\Message\ServerRequestInterface;

/**
 * QueryString Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface QueryStringInterface
{
    /**
     * Process all queries
     *
     * @return ServerRequestInterface $request
     *
     * @return QueryExprInterface
     */
    public function process(ServerRequestInterface $request);
}
