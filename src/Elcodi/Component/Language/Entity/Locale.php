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

namespace Elcodi\Component\Language\Entity;

use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;

/**
 * Class Locale
 */
class Locale implements LocaleInterface
{
    /**
     * @var string
     *
     * Iso
     */
    protected $iso;

    /**
     * Construct method
     *
     * @param string $iso Iso
     */
    public function __construct($iso)
    {
        $this->iso = $iso;
    }

    /**
     * Get Iso
     *
     * @return string Iso
     */
    public function getIso()
    {
        return $this->iso;
    }
}
