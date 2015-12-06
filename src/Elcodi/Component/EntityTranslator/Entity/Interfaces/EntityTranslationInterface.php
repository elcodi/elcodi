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

namespace Elcodi\Component\EntityTranslator\Entity\Interfaces;

/**
 * Interface EntityTranslationInterface.
 */
interface EntityTranslationInterface
{
    /**
     * Get EntityId.
     *
     * @return string EntityId
     */
    public function getEntityId();

    /**
     * Sets EntityId.
     *
     * @param string $entityId EntityId
     *
     * @return $this Self object
     */
    public function setEntityId($entityId);

    /**
     * Get EntityType.
     *
     * @return string EntityType
     */
    public function getEntityType();

    /**
     * Sets EntityType.
     *
     * @param string $entityType EntityType
     *
     * @return $this Self object
     */
    public function setEntityType($entityType);

    /**
     * Get Locale.
     *
     * @return string Locale
     */
    public function getLocale();

    /**
     * Sets Locale.
     *
     * @param string $locale Locale
     *
     * @return $this Self object
     */
    public function setLocale($locale);

    /**
     * Get Translation.
     *
     * @return string Translation
     */
    public function getTranslation();

    /**
     * Sets Translation.
     *
     * @param string $translation Translation
     *
     * @return $this Self object
     */
    public function setTranslation($translation);

    /**
     * Get EntityField.
     *
     * @return string EntityField
     */
    public function getEntityField();

    /**
     * Sets EntityField.
     *
     * @param string $entityField EntityField
     *
     * @return $this Self object
     */
    public function setEntityField($entityField);
}
