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
 */

namespace Elcodi\Component\EntityTranslator\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\EntityTranslator\Entity\Interfaces\EntityTranslationInterface;
use Elcodi\Component\EntityTranslator\Factory\EntityTranslationFactory;
use Elcodi\Component\EntityTranslator\Repository\EntityTranslationRepository;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class EntityTranslationProvider
 */
class EntityTranslationProvider implements EntityTranslationProviderInterface
{
    /**
     * @var EntityTranslationRepository
     *
     * Entity Translation repository
     */
    protected $entityTranslationRepository;

    /**
     * @var ObjectManager
     *
     * Entity Translation entity manager
     */
    protected $entityTranslationObjectManager;

    /**
     * @var EntityTranslationFactory
     *
     * Entity Translation factory
     */
    protected $entityTranslationFactory;

    /**
     * @var array
     *
     * Translations to be flushed
     */
    protected $translationsToBeFlushed;

    /**
     * Construct method
     *
     * @param EntityTranslationRepository $entityTranslationRepository    Entity Translation Repository
     * @param EntityTranslationFactory    $entityTranslationFactory       Entity Translation Factory
     * @param ObjectManager               $entityTranslationObjectManager Entity Translation Object Manager
     */
    public function __construct(
        EntityTranslationRepository $entityTranslationRepository,
        EntityTranslationFactory $entityTranslationFactory,
        ObjectManager $entityTranslationObjectManager
    )
    {
        $this->entityTranslationRepository = $entityTranslationRepository;
        $this->entityTranslationFactory = $entityTranslationFactory;
        $this->entityTranslationObjectManager = $entityTranslationObjectManager;
        $this->translationsToBeFlushed = array();
    }

    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $entityField Field of entity
     * @param string $locale      Locale
     *
     * @return string Value fetched
     */
    public function getTranslation(
        $entityType,
        $entityId,
        $entityField,
        $locale
    )
    {
        $translation = $this
            ->entityTranslationRepository
            ->findOneBy(array(
                'entityType'  => $entityType,
                'entityId'    => $entityId,
                'entityField' => $entityField,
                'locale'      => $locale,
            ));

        return $translation instanceof EntityTranslationInterface
            ? $translation->getTranslation()
            : '';
    }

    /**
     * Set translation
     *
     * @param string $entityType       Type of entity
     * @param string $entityId         Id of entity
     * @param string $entityField      Field of entity
     * @param string $translationValue Translated value
     * @param string $locale           Locale
     *
     * @return $this self Object
     */
    public function setTranslation(
        $entityType,
        $entityId,
        $entityField,
        $translationValue,
        $locale
    )
    {
        $translation = $this
            ->entityTranslationRepository
            ->findOneBy(array(
                'entityType'  => $entityType,
                'entityId'    => $entityId,
                'entityField' => $entityField,
                'locale'      => $locale,
            ));

        if (!($translation instanceof EntityTranslationInterface)) {

            $translation = $this
                ->entityTranslationFactory
                ->create()
                ->setEntityType($entityType)
                ->setEntityId($entityId)
                ->setEntityField($entityField)
                ->setLocale($locale);

            $this
                ->entityTranslationObjectManager
                ->persist($translation);
        }

        $translation->setTranslation($translationValue);

        $this->translationsToBeFlushed[] = $translation;

        return $this;
    }

    /**
     * Flush all previously set translations.
     *
     * @return $this self Object
     */
    public function flushTranslations()
    {
        $this
            ->entityTranslationObjectManager
            ->flush($this->translationsToBeFlushed);

        $this->translationsToBeFlushed = array();

        return $this;
    }
}
