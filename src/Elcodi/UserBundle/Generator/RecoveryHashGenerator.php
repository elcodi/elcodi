<?php

/**
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

namespace Elcodi\UserBundle\Generator;

use Elcodi\CoreBundle\Generator\Interfaces\GeneratorInterface;

/**
 * Class RecoveryHashGenerator
 */
class RecoveryHashGenerator implements GeneratorInterface
{
    /**
     * Generates a hash for every ReferralHash entity
     *
     * @return string Hash generated
     */
    public function generate()
    {
        return hash("sha1", uniqid(rand(), true));
    }
}
