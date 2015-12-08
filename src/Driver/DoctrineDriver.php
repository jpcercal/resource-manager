<?php

/*
 * This file is part of the Cekurte package.
 *
 * (c) João Paulo Cercal <jpcercal@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cekurte\ResourceManager\Driver;

use Cekurte\ResourceManager\Contract\DriverInterface;
use Cekurte\ResourceManager\Exception\DriverException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Doctrine Driver
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class DoctrineDriver extends \ArrayObject implements DriverInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(array $args = [])
    {
        if (!isset($args['em'])) {
            throw new DriverException(sprintf(
                'The argument "%s" can not be empty.',
                'em'
            ));
        }

        if (!$args['em'] instanceof EntityManagerInterface) {
            throw new DriverException(sprintf(
                'The argument "%s" must be a instance of %s.',
                'em',
                'Doctrine\ORM\EntityManagerInterface'
            ));
        }

        if (!is_string($args['entity'])) {
            throw new DriverException('The resource class name "entity" must be a string.');
        }

        if (empty($args['entity'])) {
            throw new DriverException('The resource class name "entity" could not be empty.');
        }

        $methods = [
            'find_resource'  => 'findResource',
            'find_resources' => 'findResources',
        ];

        if (isset($args['entity_repository_searchable_method_find_resource'])) {
            $methods['find_resource'] = $args['entity_repository_searchable_method_find_resource'];
        }

        if (isset($args['entity_repository_searchable_method_find_resources'])) {
            $methods['find_resources'] = $args['entity_repository_searchable_method_find_resources'];
        }

        $loggableRepositoryClass = '\Gedmo\Loggable\Entity\LogEntry';

        if (isset($args['entity_repository_loggable_class'])) {
            $loggableRepositoryClass = $args['entity_repository_loggable_class'];
        }

        $entityPieces = explode('\\', $args['entity']);
        $entityClass  = end($entityPieces);

        $this->offsetSet('doctrine', [
            'orm' => [
                'em' => $args['em'],
            ],
        ]);

        $this->offsetSet('entity', [
            'fqn'   => $args['entity'],
            'class' => $entityClass,
            'alias' => strtolower(substr($entityClass, 0, 1)),
            'repository'      => [
                'searchable'  => [
                    'methods' => $methods,
                ],
                'loggable'  => [
                    'class' => $loggableRepositoryClass,
                ],
            ],
        ]);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getDoctrineOrmEm()
    {
        return $this->offsetGet('doctrine')['orm']['em'];
    }

    /**
     * @return string
     */
    public function getEntityFqn()
    {
        return $this->offsetGet('entity')['fqn'];
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->offsetGet('entity')['class'];
    }

    /**
     * @return string
     */
    public function getEntityAlias()
    {
        return $this->offsetGet('entity')['alias'];
    }

    /**
     * @return string
     */
    public function getEntityRepositorySearchableMethods()
    {
        return $this->offsetGet('entity')['repository']['searchable']['methods'];
    }

    /**
     * @return string
     */
    public function getEntityRepositoryLoggableClass()
    {
        return $this->offsetGet('entity')['repository']['loggable']['class'];
    }
}
