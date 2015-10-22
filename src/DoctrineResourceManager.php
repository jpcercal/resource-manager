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

use Cekurte\ResourceManager\Contract\ResourceManagerInterface;
use Cekurte\ResourceManager\Doctrine\DoctrineResourceDeletableTrait;
use Cekurte\ResourceManager\Doctrine\DoctrineResourceLoggableTrait;
use Cekurte\ResourceManager\Doctrine\DoctrineResourceSearchableTrait;
use Cekurte\ResourceManager\Doctrine\DoctrineResourceUpdatableTrait;
use Cekurte\ResourceManager\Doctrine\DoctrineResourceWritableTrait;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Doctrine ResourceManager
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class DoctrineResourceManager implements ResourceManagerInterface
{
    use DoctrineResourceLoggableTrait;
    use DoctrineResourceSearchableTrait;
    use DoctrineResourceWritableTrait;
    use DoctrineResourceUpdatableTrait;
    use DoctrineResourceDeletableTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $resourceClassName;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $resourceClassName
     */
    public function __construct(EntityManagerInterface $entityManager, $resourceClassName)
    {
        $this
            ->setEntityManager($entityManager)
            ->setResourceClassName($resourceClassName)
        ;
    }

    /**
     * Set a entityManager.
     *
     * @param  EntityManagerInterface $entityManager
     *
     * @return DoctrineResourceManager
     */
    protected function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
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
     * @param  string $resourceClassName
     *
     * @return DoctrineResourceManager
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

        return $this;
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
}
