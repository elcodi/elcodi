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

namespace Elcodi\Component\Translator\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Component\Translator\Entity\Interfaces\TranslationInterface;
use Elcodi\Component\Translator\Factory\TranslationFactory;
use Elcodi\Component\Translator\Repository\TranslationRepository;
use Elcodi\Component\Translator\Services\Interfaces\TranslationProviderInterface;

/**
 * Class TranslationProvider
 */
class TranslationProvider implements TranslationProviderInterface
{
    /**
     * @var TranslationRepository
     *
     * Translation repository
     */
    protected $translationRepository;

    /**
     * @var ObjectManager
     *
     * Translation entity manager
     */
    protected $translationObjectManager;

    /**
     * @var TranslationFactory
     *
     * Translation factory
     */
    protected $translationFactory;

    /**
     * @var array
     *
     * Translations to be flushed
     */
    protected $translationsToBeFlushed;

    /**
     * Construct method
     *
     * @param TranslationRepository $translationRepository    Translation Repository
     * @param TranslationFactory    $translationFactory       Translation Factory
     * @param ObjectManager         $translationObjectManager Translation Object Manager
     */
    public function __construct(
        TranslationRepository $translationRepository,
        TranslationFactory $translationFactory,
        ObjectManager $translationObjectManager
    )
    {
        $this->translationRepository = $translationRepository;
        $this->translationFactory = $translationFactory;
        $this->translationObjectManager = $translationObjectManager;
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
            ->translationRepository
            ->findOneBy(array(
                'entityType'  => $entityType,
                'entityId'    => $entityId,
                'entityField' => $entityField,
                'locale'      => $locale,
            ));

        return $translation instanceof TranslationInterface
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
     * @return string Value fetched
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
            ->translationRepository
            ->findOneBy(array(
                'entityType'  => $entityType,
                'entityId'    => $entityId,
                'entityField' => $entityField,
                'locale'      => $locale,
            ));

        if (!($translation instanceof TranslationInterface)) {

            $translation = $this
                ->translationFactory
                ->create()
                ->setEntityType($entityType)
                ->setEntityId($entityId)
                ->setEntityField($entityField)
                ->setLocale($locale);

            $this
                ->translationObjectManager
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
            ->translationObjectManager
            ->flush($this->translationsToBeFlushed);

        $this->translationsToBeFlushed = array();

        return $this;
    }
}
