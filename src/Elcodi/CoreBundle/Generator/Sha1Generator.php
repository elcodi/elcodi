<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Generator;

use Elcodi\CoreBundle\Generator\Interfaces\GeneratorInterface;

/**
 * Class Sha1Generator
 *
 * This class is a sha1 string generator.
 */
class Sha1Generator implements GeneratorInterface
{
    /**
     * Generates a random string
     *
     * @return string Result of generation
     */
    public function generate()
    {
        return hash("sha1", uniqid(rand(), true));
    }
}
