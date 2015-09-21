<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\EntityTranslator\Services\Interfaces;

/**
 * Interface EntityTranslatorInterface
 */
interface EntityTranslatorInterface
{
    /**
     * Translate object
     *
     * @param Object $object Object
     * @param string $locale Locale to be translated
     */
    public function translate($object, $locale);

    /**
     * Saves object translations
     *
     * @param Object $object       Object
     * @param array  $translations Translations
     */
    public function save($object, array $translations);
}
