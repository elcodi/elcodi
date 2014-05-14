<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since 2013
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
