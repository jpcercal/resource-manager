<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager;

use Cekurte\ResourceManager\Contract\QueryExprInterface;
use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\Contract\ResourceManagerInterface;
use Cekurte\ResourceManager\Exception\ResourceDataNotFoundException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedDeleteException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedLogException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException;
use Cekurte\ResourceManager\Query\Expr\DoctrineQueryExpr;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Doctrine ResourceManager
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class DoctrineResourceManager implements ResourceManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $resourceClassName;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $resourceClassName
     */
    public function __construct(EntityManagerInterface $entityManager, $resourceClassName)
    {
        $this->entityManager = $entityManager;

        $this->setResourceClassName($resourceClassName);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set a resource class name.
     *
     * @param string $resourceClassName
     */
    protected function setResourceClassName($resourceClassName)
    {
        if (!is_string($resourceClassName)) {
            throw new \InvalidArgumentException('The resource class name could be a string.');
        }

        if (empty($resourceClassName)) {
            throw new \InvalidArgumentException('The resource class name could not be empty.');
        }

        $this->resourceClassName = $resourceClassName;
    }

    /**
     * Get and setup a QueryBuilder instance
     *
     * @param  QueryExprInterface|null $queryExpr
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilder(QueryExprInterface $queryExpr = null)
    {
        $queryBuilder = $this
            ->getEntityManager()
            ->getRepository($this->getResourceClassName())
            ->createQueryBuilder($this->getAlias())
        ;

        if (!empty($queryExpr)) {
            foreach ($queryExpr as $item) {
                $queryBuilder->andWhere($item['expr']['resource']);

                foreach ($item['params'] as $key => $value) {
                    $queryBuilder->setParameter($key, $value);
                }
            }
        }

        return $queryBuilder;
    }

    /**
     * Get the resource class name.
     *
     * @return string
     */
    public function getResourceClassName()
    {
        return $this->resourceClassName;
    }

    /**
     * Get the alias.
     *
     * @return string
     */
    public function getAlias()
    {
        $className = end(explode('\\', $this->getResourceClassName()));

        return strtolower(substr($className, 0, 1));
    }

    /**
     * @inheritdoc
     */
    public function getLogEntries(ResourceInterface $resource)
    {
        try {
            return $this
                ->getEntityManager()
                ->getRepository('\Gedmo\Loggable\Entity\LogEntry')
                ->getLogEntries($resource)
            ;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedLogException($e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function findResource(QueryExprInterface $queryExpr)
    {
        try {
            return $this->getQueryBuilder($queryExpr)->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new ResourceDataNotFoundException(sprintf(
                'The resource "%s" was not found. ' . $queryExpr,
                $this->getResourceClassName()
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function findResources(QueryExprInterface $queryExpr = null)
    {
        return $this->getQueryBuilder($queryExpr)->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function writeResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->persist($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedWriteException($e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function updateResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->persist($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedUpdateException($e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteResource(ResourceInterface $resource)
    {
        try {
            $this->getEntityManager()->remove($resource);
            $this->getEntityManager()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedDeleteException($e->getMessage());
        }
    }
}
