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

namespace Elcodi\Component\Menu\Adapter\RouteGenerator\Interfaces;

/**
 * Interface RouterGeneratorAdapterInterface
 */
interface RouteGeneratorAdapterInterface
{
    /**
     * Provides a method to generate an URL starting from a route name
     *
     * @param string $routeName route name
     *
     * @return string
     */
    public function generateUrl($routeName);
}
