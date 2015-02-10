<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\EntityTranslator\Entity;

use Elcodi\Component\EntityTranslator\Entity\Interfaces\EntityTranslationInterface;

/**
 * Class EntityTranslation
 */
class EntityTranslation implements EntityTranslationInterface
{
    /**
     * @var string
     *
     * Entity type
     */
    protected $entityType;

    /**
     * @var string
     *
     * Entity identifier
     */
    protected $entityId;

    /**
     * @var string
     *
     * Entity field
     */
    protected $entityField;

    /**
     * @var string
     *
     * Translation
     */
    protected $translation;

    /**
     * @var string
     *
     * Locale
     */
    protected $locale;

    /**
     * Get EntityId
     *
     * @return string EntityId
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Sets EntityId
     *
     * @param string $entityId EntityId
     *
     * @return $this Self object
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get EntityType
     *
     * @return string EntityType
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * Sets EntityType
     *
     * @param string $entityType EntityType
     *
     * @return $this Self object
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    /**
     * Get Locale
     *
     * @return string Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets Locale
     *
     * @param string $locale Locale
     *
     * @return $this Self object
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get Translation
     *
     * @return string Translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Sets Translation
     *
     * @param string $translation Translation
     *
     * @return $this Self object
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get EntityField
     *
     * @return string EntityField
     */
    public function getEntityField()
    {
        return $this->entityField;
    }

    /**
     * Sets EntityField
     *
     * @param string $entityField EntityField
     *
     * @return $this Self object
     */
    public function setEntityField($entityField)
    {
        $this->entityField = $entityField;

        return $this;
    }
}
