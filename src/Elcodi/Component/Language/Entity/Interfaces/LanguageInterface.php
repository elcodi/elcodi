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

namespace Elcodi\Component\Language\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface LanguageInterface
 */
interface LanguageInterface extends EnabledInterface
{
    /**
     * Set language name
     *
     * @param string $name Name of the shop
     *
     * @return LanguageInterface self Object
     */
    public function setName($name);

    /**
     * Get shop name
     *
     * @return string
     */
    public function getName();

    /**
     * Set iso
     *
     * @param string $iso Iso
     *
     * @return LanguageInterface self Object
     */
    public function setIso($iso);

    /**
     * Get iso
     *
     * @return string
     */
    public function getIso();
}
