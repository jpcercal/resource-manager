<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Doctrine;

use Cekurte\ResourceManager\Contract\QueryExprInterface;
use Cekurte\ResourceManager\Exception\ResourceException;
use Doctrine\ORM\QueryBuilder;

/**
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
trait DoctrineResourceSearchableTrait
{
    /**
     * Get the alias.
     *
     * @return string
     */
    protected function getAlias()
    {
        $className = end(explode('\\', $this->getResourceClassName()));

        return strtolower(substr($className, 0, 1));
    }

    /**
     * Get the entity repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getEntityRepository()
    {
        return $this
            ->getEntityManager()
            ->getRepository($this->getResourceClassName())
        ;
    }

    /**
     * Process the QueryExpr object.
     *
     * @param  QueryBuilder            $queryBuilder
     * @param  QueryExprInterface|null $queryExpr
     */
    protected function processQueryExpr(QueryBuilder $queryBuilder, QueryExprInterface $queryExpr = null)
    {
        if (!empty($queryExpr)) {
            foreach ($queryExpr as $item) {
                $queryBuilder->andWhere($item['expr']['resource']);

                foreach ($item['params'] as $key => $value) {
                    $queryBuilder->setParameter($key, $value);
                }
            }
        }
    }

    /**
     * Get the QueryBuilder instance.
     *
     * @param  string $repositoryMethod
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilder($repositoryMethod)
    {
        $repository = $this->getEntityRepository();

        if (!method_exists($repository, $repositoryMethod)) {
            return $repository->createQueryBuilder($this->getAlias());
        }

        $queryBuilder = $repository->$repositoryMethod();

        if (!$queryBuilder instanceof QueryBuilder) {
            throw new ResourceException(sprintf(
                'The method "%s" of repository class must be return a %s instance',
                $repositoryMethod,
                '\Doctrine\ORM\QueryBuilder'
            ));
        }

        return $queryBuilder;
    }

    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceSearchableInterface::findResource
     */
    public function findResource(QueryExprInterface $queryExpr)
    {
        try {
            $queryBuilder = $this->getQueryBuilder('findResource');

            $this->processQueryExpr($queryBuilder, $queryExpr);

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new ResourceDataNotFoundException(sprintf(
                'The resource "%s" was not found. ' . $queryExpr,
                $this->getResourceClassName()
            ));
        }
    }

    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceSearchableInterface::findResources
     */
    public function findResources(QueryExprInterface $queryExpr = null)
    {
        $queryBuilder = $this->getQueryBuilder('findResources');

        $this->processQueryExpr($queryBuilder, $queryExpr);

        return $queryBuilder->getQuery()->getResult();
    }
}
