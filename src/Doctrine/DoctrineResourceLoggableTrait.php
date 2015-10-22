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

use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\Contract\ResourceLoggableInterface;
use Cekurte\ResourceManager\Exception\ResourceManagerRefusedLogException;

/**
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
trait DoctrineResourceLoggableTrait
{
    /**
     * @var string
     */
    protected $loggableEntityRepository = '\Gedmo\Loggable\Entity\LogEntry';

    /**
     * @param string $loggableEntityRepository
     *
     * @return ResourceLoggableInterface
     */
    public function setLoggableEntityRepository($loggableEntityRepository)
    {
        $this->loggableEntityRepository = $loggableEntityRepository;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoggableEntityRepository()
    {
        return $this->loggableEntityRepository;
    }

    /**
     * @see \Cekurte\ResourceManager\Contract\ResourceLoggableInterface::getLogEntries
     */
    public function getLogEntries(ResourceInterface $resource)
    {
        try {
            return $this
                ->getEntityManager()
                ->getRepository($this->getLoggableEntityRepository())
                ->getLogEntries($resource)
            ;
        } catch (\Exception $e) {
            throw new ResourceManagerRefusedLogException($e->getMessage());
        }
    }
}
