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
use Cekurte\ResourceManager\Query\Expr\AbstractQueryExpr;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;

/**
 * DoctrineQuery Expr
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class DoctrineQueryExpr extends AbstractQueryExpr implements QueryExprInterface
{
    /**
     * @var Expr
     */
    protected $exprBuilder;

    /**
     * @return Expr
     */
    protected function getExprBuilder()
    {
        if ($this->exprBuilder === null) {
            $this->exprBuilder = new Expr();
        }

        return $this->exprBuilder;
    }

    /**
     * Get the parameter key using the node
     *
     * @param  string $node
     *
     * @return string
     */
    protected function getParameterKeyByNode($node)
    {
        return end(explode('.', $node));
    }

    /**
     * Get expression to comparison
     *
     * @param  string $node
     * @param  string $expr
     * @param  mixed  $value
     *
     * @return array
     */
    public function getExprComparison($node, $expr, $value)
    {
        $alias = $this->getParameterKeyByNode($node);

        return [
            'expr' => [
                'type' => $expr,
                'resource' => $this->getExprBuilder()->{$expr}($node, sprintf(':%s', $alias)),
            ],
            'params' => [
                $alias => $value
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function eq($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'eq', $value));
    }

    /**
     * @inheritdoc
     */
    public function neq($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'neq', $value));
    }

    /**
     * @inheritdoc
     */
    public function between($node, $value)
    {
        list($fromValue, $toValue) = explode('-', $value);

        $alias = $this->getParameterKeyByNode($node);

        $keyFrom = sprintf('%sFrom', $alias);
        $keyTo   = sprintf('%sTo', $alias);

        $this->enqueue([
            'expr' => [
                'type' => 'between',
                'resource' => $this->getExprBuilder()->between($node, sprintf(':%s', $keyFrom), sprintf(':%s', $keyTo)),
            ],
            'params' => [
                $keyFrom => $fromValue,
                $keyTo   => $toValue,
            ],
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function like($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'like', $value));
    }

    /**
     * @inheritdoc
     */
    public function gt($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'gt', $value));
    }

    /**
     * @inheritdoc
     */
    public function gte($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'gte', $value));
    }

    /**
     * @inheritdoc
     */
    public function lt($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'lt', $value));
    }

    /**
     * @inheritdoc
     */
    public function lte($node, $value)
    {
        return $this->enqueue($this->getExprComparison($node, 'lte', $value));
    }
}
