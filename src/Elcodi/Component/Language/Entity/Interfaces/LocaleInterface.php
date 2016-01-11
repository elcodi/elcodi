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

/**
 * Interface LocaleInterface.
 */
interface LocaleInterface
{
    /**
     * Get Iso.
     *
     * @return string Iso
     */
    public function getIso();

    /**
     * Create new instance.
     *
     * @param string $localeIso Locale iso
     *
     * @return self New instance
     */
    public static function create($localeIso);
}
