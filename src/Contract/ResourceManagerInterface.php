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

use Cekurte\ResourceManager\Contract\ResourceDeletableInterface;
use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\Contract\ResourceLoggableInterface;
use Cekurte\ResourceManager\Contract\ResourceSearchableInterface;
use Cekurte\ResourceManager\Contract\ResourceUpdatableInterface;
use Cekurte\ResourceManager\Contract\ResourceWritableInterface;

/**
 * ResourceManager Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface ResourceManagerInterface extends
    ResourceInterface,
    ResourceLoggableInterface,
    ResourceSearchableInterface,
    ResourceWritableInterface,
    ResourceUpdatableInterface,
    ResourceDeletableInterface
{

}
