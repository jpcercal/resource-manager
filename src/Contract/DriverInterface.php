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

/**
 * Driver Interface
 *
 * @author João Paulo Cercal <jpcercal@gmail.com>
 */
interface DriverInterface
{
    /**
     * @param array $args Arguments to setup the driver
     */
    public function __construct(array $args = []);
}
