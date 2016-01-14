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

namespace Elcodi\Component\Core\Generator\Interfaces;

/**
 * Interface GeneratorInterface.
 *
 * This interface is for static generators.
 *
 * An static generator does not have any kind of customizable behaviour, its public
 * implementable method called generate() does not accept any parameter except for
 * the length of the string to be generated, so the result should not depend on
 * its context.
 */
interface GeneratorInterface
{
    /**
     * Generates a hash.
     *
     * @param int $length Length of string generated
     *
     * @return string Generation
     */
    public function generate($length = null);
}
