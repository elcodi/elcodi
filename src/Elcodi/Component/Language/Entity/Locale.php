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

namespace Elcodi\Component\Language\Entity;

use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;

/**
 * Class Locale.
 */
class Locale implements LocaleInterface
{
    /**
     * @var string
     *
     * Locale iso
     */
    protected $localeIso;

    /**
     * Construct method.
     *
     * @param string $localeIso Locale iso
     */
    public function __construct($localeIso)
    {
        $this->localeIso = $localeIso;
    }

    /**
     * Get Iso.
     *
     * @return string Iso
     */
    public function getIso()
    {
        return $this->localeIso;
    }

    /**
     * Create new instance.
     *
     * @param string $localeIso Locale iso
     *
     * @return self New instance
     */
    public static function create($localeIso)
    {
        return new self($localeIso);
    }
}
