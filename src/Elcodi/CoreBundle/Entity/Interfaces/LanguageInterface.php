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

namespace Elcodi\CoreBundle\Entity\Interfaces;

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
