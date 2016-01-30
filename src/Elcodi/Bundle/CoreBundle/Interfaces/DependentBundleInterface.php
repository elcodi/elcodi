<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CoreBundle\Interfaces;

use Symfony\Component\HttpKernel\KernelInterface;

@trigger_error('Warning. This feature is extracted from Elcodi and placed in the
repository mmoreram/symfony-bundle-dependencies. Will be removed permanently in
v2.0.0.', E_USER_DEPRECATED);

/**
 * Interface DependentBundleInterface.
 */
interface DependentBundleInterface
{
    /**
     * Return all bundle dependencies.
     *
     * Values can be a simple bundle namespace or its instance
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel);
}
