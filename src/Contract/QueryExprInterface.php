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

/**
 * QueryExpr Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface QueryExprInterface
{
    /**
     * Equals
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function eq($node, $value);

    /**
     * Not Equals
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function neq($node, $value);

    /**
     * Between
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function between($node, $value);

    /**
     * Like
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function like($node, $value);

    /**
     * Greater than
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function gt($node, $value);

    /**
     * Not Greater than
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function gte($node, $value);

    /**
     * Lower than
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function lt($node, $value);

    /**
     * Not Lower than
     *
     * @param  string $node
     * @param  mixed  $value
     *
     * @return QueryExprInterface
     */
    public function lte($node, $value);

    /**
     * Export the queue to string
     *
     * @return string
     */
    public function __toString();
}
