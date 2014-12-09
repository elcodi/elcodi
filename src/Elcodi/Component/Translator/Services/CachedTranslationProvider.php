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
use Elcodi\Component\Translator\Entity\Interfaces\TranslationInterface;
use Elcodi\Component\Translator\Repository\TranslationRepository;
use Elcodi\Component\Translator\Services\Interfaces\TranslationProviderInterface;

/**
 * Class CachedTranslationProvider
 */
class CachedTranslationProvider implements TranslationProviderInterface
{
    /**
     * @var TranslationProviderInterface
     *
     * Translation Provider
     */
    protected $translatorProvider;

    /**
     * @var TranslationRepository
     *
     * Translation repository
     */
    protected $translationRepository;

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
     * Construct method
     *
     * @param TranslationProviderInterface $translationProvider   Translation Provider
     * @param TranslationRepository        $translationRepository Translation Repository
     * @param Cache                        $cache                 Cache
     * @param string                       $cachePrefix           Cache prefix
     */
    public function __construct(
        TranslationProviderInterface $translationProvider,
        TranslationRepository $translationRepository,
        Cache $cache,
        $cachePrefix
    )
    {
        $this->translationProvider = $translationProvider;
        $this->translationRepository = $translationRepository;
        $this->cache = $cache;
        $this->cachePrefix = $cachePrefix;
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
        $cacheKey = $this->buildKey(
            $entityType,
            $entityId,
            $entityField,
            $locale
        );

        $translation = $this
            ->cache
            ->fetch($cacheKey);

        if ($translation === false) {

            $translation = $this
                ->translationProvider
                ->getTranslation(
                    $entityType,
                    $entityId,
                    $entityField,
                    $locale
                );

            $this
                ->cache
                ->save(
                    $cacheKey,
                    $translation
                );
        }

        return $translation;
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
        $this
            ->translationProvider
            ->setTranslation(
                $entityType,
                $entityId,
                $entityField,
                $translationValue,
                $locale
            );

        $cacheKey = $this->buildKey(
            $entityType,
            $entityId,
            $entityField,
            $locale
        );

        $this
            ->cache
            ->save(
                $cacheKey,
                $translationValue
            );

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
            ->translationProvider
            ->flushTranslations();

        return $this;
    }

    /**
     * Warm-up translations
     *
     * @return $this self Object
     */
    public function warmUp()
    {
        $translations = $this
            ->translationRepository
            ->findAll();

        /**
         * @var $translation TranslationInterface
         */
        foreach ($translations as $translation) {

            $cacheKey = $this->buildKey(
                $translation->getEntityType(),
                $translation->getEntityId(),
                $translation->getEntityField(),
                $translation->getLocale()
            );

            $this
                ->cache
                ->save(
                    $cacheKey,
                    $translation->getTranslation()
                );
        }

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
 