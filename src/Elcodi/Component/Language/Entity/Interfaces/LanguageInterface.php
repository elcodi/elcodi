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

namespace Elcodi\Component\Language\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface LanguageInterface.
 */
interface LanguageInterface
    extends
    IdentifiableInterface,
    EnabledInterface
{
    /**
     * Set language name.
     *
     * @param string $name Name of the shop
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get shop name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set iso.
     *
     * @param string $iso Iso
     *
     * @return $this Self object
     */
    public function setIso($iso);

    /**
     * Get iso.
     *
     * @return string
     */
    public function getIso();
}
