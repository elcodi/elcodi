<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
 * Interface EntityTranslationProviderInterface
 */
interface EntityTranslationProviderInterface
{
    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $entityField Field of entity
     * @param string $locale      Locale
     *
     * @return string|boolean Value fetched
     */
    public function getTranslation(
        $entityType,
        $entityId,
        $entityField,
        $locale
    );

    /**
     * Set translation
     *
     * @param string         $entityType       Type of entity
     * @param string         $entityId         Id of entity
     * @param string         $entityField      Field of entity
     * @param string|boolean $translationValue Translated value
     * @param string         $locale           Locale
     *
     * @return $this Self object
     */
    public function setTranslation(
        $entityType,
        $entityId,
        $entityField,
        $translationValue,
        $locale
    );

    /**
     * Flush all previously set translations.
     *
     * @return $this Self object
     */
    public function flushTranslations();
}
