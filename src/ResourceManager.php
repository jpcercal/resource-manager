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

use Cekurte\ResourceManager\Contract\DriverInterface;
use Cekurte\ResourceManager\Contract\ResourceManagerInterface;
use Cekurte\ResourceManager\Driver\DoctrineDriver;
use Cekurte\ResourceManager\Service\DoctrineResourceManager;

/**
 * ResourceManager
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
class ResourceManager
{
    /**
     * Create a instance of ResourceManagerInterface.
     *
     * @param  string|DriverInterface $driver driver name
     * @param  array  $args                   if the fisrt argument is a string this
     *                                        argument is used to set the driver options.
     *
     * @return ResourceManagerInterface
     *
     * @throws \InvalidArgumentException
     */
    public static function create($driver, array $args = [])
    {
        if (is_string($driver) && lcfirst($driver) === 'doctrine') {
            return new DoctrineResourceManager(new DoctrineDriver($args));
        } elseif ($driver instanceof DoctrineDriver) {
            return new DoctrineResourceManager($driver);
        }

        throw new \InvalidArgumentException(sprintf(
            'The driver "%s" can not be found.',
            is_string($driver) ? lcfirst($driver) : get_class($driver)
        ));
    }
}
