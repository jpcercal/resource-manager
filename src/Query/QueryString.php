<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Query;

use Cekurte\ResourceManager\Contract\QueryStringInterface;
use Cekurte\ResourceManager\Query\Expr\DoctrineQueryExpr;
use Psr\Http\Message\ServerRequestInterface;

/**
 * QueryString
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class QueryString implements QueryStringInterface
{
    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request)
    {
        $queryParams = $request->getQueryParams();

        $queries = isset($queryParams['q']) ? $queryParams['q'] : [];

        $queryExpr = new DoctrineQueryExpr();

        if (!empty($queries)) {
            foreach ($queries as $query) {
                list($field, $expr, $value) = explode(':', $query);

                if (method_exists($queryExpr, $expr)) {
                    $queryExpr->{$expr}($field, $value);
                }
            }
        }

        return $queryExpr;
    }
}
