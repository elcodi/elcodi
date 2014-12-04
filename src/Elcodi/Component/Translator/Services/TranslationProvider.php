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

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Component\Translator\Entity\Interfaces\TranslationInterface;
use Elcodi\Component\Translator\Entity\Translation;
use Elcodi\Component\Translator\Factory\TranslationFactory;
use Elcodi\Component\Translator\Repository\TranslationRepository;

/**
 * Class TranslationProvider
 */
class TranslationProvider
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
     * @var Cache
     *
     * Cache
     */
    protected $cache;

    /**
     * @var string
     *
     * Cache key
     */
    protected $cachePrefix;

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
     * @param Cache                 $cache                    Cache
     * @param string                $cachePrefix              Cache prefix
     */
    public function __construct(
        TranslationRepository $translationRepository,
        TranslationFactory $translationFactory,
        ObjectManager $translationObjectManager,
        Cache $cache,
        $cachePrefix
    )
    {
        $this->translationRepository = $translationRepository;
        $this->translationFactory = $translationFactory;
        $this->translationObjectManager = $translationObjectManager;
        $this->cache = $cache;
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * Warm-up translations
     */
    public function warmUp()
    {
        $translations = $this
            ->translationRepository
            ->findAll();

        /**
         * @var $translation Translation
         */
        foreach ($translations as $translation) {

            $key = $this->buildKey(
                $translation->getEntityType(),
                $translation->getEntityId(),
                $translation->getEntityField(),
                $translation->getLocale()
            );

            $this
                ->cache
                ->save(
                    $key,
                    $translation->getTranslation()
                );
        }
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
        $key = $this->buildKey(
            $entityType,
            $entityId,
            $entityField,
            $locale
        );

        return $this
            ->cache
            ->fetch($key);
    }

    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $entityField Field of entity
     * @param string $value       Translated value
     * @param string $locale      Locale
     *
     * @return string Value fetched
     */
    public function setTranslation(
        $entityType,
        $entityId,
        $entityField,
        $value,
        $locale
    )
    {
        $key = $this->buildKey(
            $entityType,
            $entityId,
            $entityField,
            $locale
        );

        $this
            ->cache
            ->save(
                $key,
                $value
            );

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

        $translation->setTranslation($value);

        $this->translationsToBeFlushed[] = $translation;

        return $this;
    }

    /**
     * Flush translations
     */
    public function flushTranslations()
    {
        $this
            ->translationObjectManager
            ->flush($this->translationsToBeFlushed);

        $this->translationsToBeFlushed = array();

        return $this;
    }

    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $entityField Field of entity
     * @param string $locale      Locale
     *
     * @return string Key
     */
    protected function buildKey(
        $entityType,
        $entityId,
        $entityField,
        $locale
    )
    {
        return $this->cachePrefix . '_' .
        $entityType . '_' .
        $entityId . '_' .
        $entityField . '_' .
        $locale;
    }
}
