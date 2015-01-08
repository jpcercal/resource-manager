<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Service;

use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\Contract\ResourceManagerInterface;
use Cekurte\ResourceManager\Driver\DoctrineDriver;
use Cekurte\ResourceManager\Exception\ResourceDataNotFoundException;
use Cekurte\ResourceManager\Exception\ResourceException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedDeleteException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedLogException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException;
use Cekurte\Resource\Query\Language\ExprQueue;
use Cekurte\Resource\Query\Language\Processor\DoctrineOrmProcessor;
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
     * @var DoctrineDriver
     */
    protected $driver;

    /**
     * @param DoctrineDriver $driver
     */
    public function __construct(DoctrineDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return DoctrineDriver
     */
    public function getDriver()
    {
        return $this->driver;
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
        $repository = $this
            ->getDriver()
            ->getDoctrineOrmEm()
            ->getRepository($this->getDriver()->getEntityFqn())
        ;

        $repositoryMethods = $this->getDriver()->getEntityRepositorySearchableMethods();

        if (!method_exists($repository, $repositoryMethods[$repositoryMethod])) {
            return $repository->createQueryBuilder($this->getDriver()->getEntityAlias());
        }

        $queryBuilder = $repository->$repositoryMethods[$repositoryMethod]();

        if (!$queryBuilder instanceof QueryBuilder) {
            throw new ResourceException(sprintf(
                'The method "%s" of repository class must be return a %s instance',
                $repositoryMethods[$repositoryMethod],
                '\Doctrine\ORM\QueryBuilder'
            ));
        }

        return $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getLogEntries(ResourceInterface $resource)
    {
        try {
            return $this
                ->getDriver()
                ->getDoctrineOrmEm()
                ->getRepository($this->getDriver()->getEntityRepositoryLoggableClass())
                ->getLogEntries($resource)
            ;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedLogException($e->getMessage());
        }
    }

    /**
     * @param  DoctrineOrmProcessor $processor
     * @param  ExprQueue            $queue
     *
     * @return QueryBuilder
     */
    protected function processQueue(DoctrineOrmProcessor $processor, ExprQueue $queue)
    {
        return $processor->process($queue);
    }

    /**
     * @inheritdoc
     */
    public function findResource(ExprQueue $queue)
    {
        try {
            $queryBuilder = $this->getQueryBuilder('find_resource');

            $this->processQueue(new DoctrineOrmProcessor($queryBuilder), $queue);

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new ResourceDataNotFoundException(sprintf(
                'The resource "%s" was not found using the following expressions: %s',
                PHP_EOL . $queue,
                $this->getDriver()->getEntityClass()
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function findResources(ExprQueue $queue = null)
    {
        $queryBuilder = $this->getQueryBuilder('find_resources');

        if (!is_null($queue)) {
            $this->processQueue(new DoctrineOrmProcessor($queryBuilder), $queue);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function writeResource(ResourceInterface $resource)
    {
        try {
            $this->getDriver()->getDoctrineOrmEm()->persist($resource);
            $this->getDriver()->getDoctrineOrmEm()->flush();

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
            $this->getDriver()->getDoctrineOrmEm()->persist($resource);
            $this->getDriver()->getDoctrineOrmEm()->flush();

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
            $this->getDriver()->getDoctrineOrmEm()->remove($resource);
            $this->getDriver()->getDoctrineOrmEm()->flush();

            return true;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedDeleteException($e->getMessage());
        }
    }
}
