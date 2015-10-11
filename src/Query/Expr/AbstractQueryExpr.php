<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Query\Expr;

use Cekurte\ResourceManager\Contract\QueryExprInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;

/**
 * AbstractQuery Expr
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 *
 * @abstract
 */
abstract class AbstractQueryExpr extends \SplQueue implements QueryExprInterface
{
    /**
     * @param mixed $value
     *
     * @return QueryExprInterface
     */
    public function enqueue($value)
    {
        parent::enqueue($value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function eq($node, $value)
    {
        throw new \BadMethodCallException('The expression "eq" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function neq($node, $value)
    {
        throw new \BadMethodCallException('The expression "neq" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function between($node, $value)
    {
        throw new \BadMethodCallException('The expression "between" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function like($node, $value)
    {
        throw new \BadMethodCallException('The expression "like" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function gt($node, $value)
    {
        throw new \BadMethodCallException('The expression "gt" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function gte($node, $value)
    {
        throw new \BadMethodCallException('The expression "gte" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function lt($node, $value)
    {
        throw new \BadMethodCallException('The expression "lt" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function lte($node, $value)
    {
        throw new \BadMethodCallException('The expression "lte" not is implemented.');
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'The queue of QueryExpr is empty!';
        }

        $data = 'Filter conditions: ';

        while (!$this->isEmpty()) {
            $current = $this->dequeue();

            $data .= PHP_EOL;
            $data .= sprintf(
                '[%s] %s with value(s): "%s"',
                $current['expr']['type'],
                $current['expr']['resource'],
                implode(', ', $current['params'])
            );
        }

        return $data;
    }
}
