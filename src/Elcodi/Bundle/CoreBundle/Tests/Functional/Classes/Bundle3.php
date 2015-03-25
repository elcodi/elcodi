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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CoreBundle\Tests\Functional\Classes;

use Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface;

/**
 * Class Bundle3
 */
class Bundle3 implements DependentBundleInterface
{
    /**
     * Create instance of current bundle, and return dependent bundle namespaces
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies()
    {
        return [
            'Elcodi\Bundle\CoreBundle\Tests\Functional\Classes\Bundle1',
            'Elcodi\Bundle\CoreBundle\Tests\Functional\Classes\Bundle2',
            'Elcodi\Bundle\CoreBundle\Tests\Functional\Classes\Bundle4',
        ];
    }
}
