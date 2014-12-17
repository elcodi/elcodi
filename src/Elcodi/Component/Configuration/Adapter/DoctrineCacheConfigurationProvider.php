<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Configuration\Adapter;

use Elcodi\Component\Configuration\Adapter\Interfaces\ConfigurationProviderInterface;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;

/**
 * Class DoctrineCacheConfigurationProvider
 */
class DoctrineCacheConfigurationProvider extends AbstractCacheWrapper implements ConfigurationProviderInterface
{
    /**
     * @var string
     *
     * Adapter name
     */
    const ADAPTER_NAME = 'doctrine_cache';

    /**
     * Sets a parameter value
     *
     * @param $parameter
     * @param $value
     *
     * @return $this self Object
     */
    public function setParameter($parameter, $value, $namespace = "")
    {
        $namespace = $namespace ? "$namespace." : "";

        $this
            ->cache
            ->save($namespace.$parameter, $value);

        return $this;
    }

    /**
     * @param $parameter
     *
     * @return null|string
     */
    public function getParameter($parameter, $namespace = "")
    {
        $namespace = $namespace ? "$namespace." : "";

        return $this
            ->cache
            ->fetch($namespace.$parameter);
    }
}
