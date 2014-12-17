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

namespace Elcodi\Component\Configuration\Adapter\Interfaces;

/**
 * Interface ConfigurationProviderInterface
 */
interface ConfigurationProviderInterface
{
    /**
     * Gets a parameter value
     *
     * @param $parameter string parameter name
     * @param $namespace string namespace
     *
     * @return null|string
     */
    public function getParameter($parameter, $namespace = "");

    /**
     * Sets a parameter value
     *
     * @param $parameter string parameter name
     * @param $value     string parameter value
     * @param $namespace string namespace
     *
     * @return $this self Object
     */
    public function setParameter($parameter, $value, $namespace = "");
}
