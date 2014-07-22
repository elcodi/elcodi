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

namespace Elcodi\GeoBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * interface CountryInterface
 */
interface CountryInterface extends EnabledInterface
{
    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return CountryInterface Self object
     */
    public function setCode($code);

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return CountryInterface Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();
}
