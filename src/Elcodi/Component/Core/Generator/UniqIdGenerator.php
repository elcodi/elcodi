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

namespace Elcodi\Component\Core\Generator;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;

/**
 * Class UniqIdGenerator.
 *
 * This class is a unique id generator.
 */
class UniqIdGenerator implements GeneratorInterface
{
    /**
     * Generates a unique Id.
     *
     * @param int|null $length Length of string generated
     *
     * @return string Result of generation
     */
    public function generate($length = null)
    {
        return uniqid('', true);
    }
}
