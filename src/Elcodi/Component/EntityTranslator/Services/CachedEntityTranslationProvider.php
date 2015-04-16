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

namespace Elcodi\Component\EntityTranslator\Services;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\EntityTranslator\Entity\Interfaces\EntityTranslationInterface;
use Elcodi\Component\EntityTranslator\Repository\EntityTranslationRepository;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class CachedEntityTranslationProvider
 */
class CachedEntityTranslationProvider extends AbstractCacheWrapper implements EntityTranslationProviderInterface
{
    /**
     * @var EntityTranslationProviderInterface
     *
     * Entity Translation Provider
     */
    protected $entityTranslatorProvider;

    /**
     * @var EntityTranslationRepository
     *
     * Entity Translation repository
     */
    protected $entityTranslationRepository;

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
     * @param EntityTranslationProviderInterface $entityTranslationProvider   Translation Provider
     * @param EntityTranslationRepository        $entityTranslationRepository Entity Translation Repository
     * @param string                             $cachePrefix                 Cache prefix
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        EntityTranslationRepository $entityTranslationRepository,
        $cachePrefix
    ) {
        $this->entityTranslatorProvider = $entityTranslationProvider;
        $this->entityTranslationRepository = $entityTranslationRepository;
        $this->cachePrefix = $cachePrefix;
        $this->translationsToBeFlushed = [];
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
    ) {
        $cacheKey = $this->buildKey(
            $entityType,
            $entityId,
            $locale
        );

        $translationUnit = $this
            ->cache
            ->fetch($cacheKey);

        if ($translationUnit === false) {
            $translationUnit = $this
                ->entityTranslatorProvider
                ->getTranslationUnit(
                    $entityType,
                    $entityId,
                    $locale
                );

            $this
                ->cache
                ->save(
                    $cacheKey,
                    $translationUnit
                );
        }

        return $translationUnit[$entityField];
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
    ) {
        $cacheKey = $this->buildKey(
            $entityType,
            $entityId,
            $locale
        );

        $translationUnit = $this->entityTranslatorProvider->getTranslationUnit(
            $entityType,
            $entityId,
            $locale
        );

        $translationUnit[$entityField] = $translationValue;

        $this
            ->cache
            ->save(
                $cacheKey,
                $translationUnit
            );

        return $this
            ->entityTranslatorProvider
            ->setTranslation(
                $entityType,
                $entityId,
                $entityField,
                $translationValue,
                $locale
            );
    }

    /**
     * Flush all previously set translations.
     *
     * @return $this Self object
     */
    public function flushTranslations()
    {
        return $this
            ->entityTranslatorProvider
            ->flushTranslations();
    }

    /**
     * Warm-up translations
     *
     * @return $this Self object
     */
    public function warmUp()
    {
        $translations = $this
            ->entityTranslationRepository
            ->findAll();

        /**
         * @var EntityTranslationInterface $translation
         */
        foreach ($translations as $translation) {
            $cacheKey = $this->buildKey(
                $translation->getEntityType(),
                $translation->getEntityId(),
                $translation->getLocale()
            );

            $translationUnit = $this->cache->fetch($cacheKey);
            if ($translationUnit === false) {
                $translationUnit = [];
            }

            $translationUnit[$translation->getEntityField()] = $translation->getTranslation();

            $this
                ->cache
                ->save(
                    $cacheKey,
                    $translationUnit
                );
        }

        return $this;
    }

    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $locale      Locale
     *
     * @return string Key
     */
    protected function buildKey(
        $entityType,
        $entityId,
        $locale
    ) {
        return $this->cachePrefix . '_' .
        $entityType . '_' .
        $entityId . '_' .
        $locale;
    }

    /**
     * Get translation unit
     *
     * @param string $entityType Type of entity
     * @param string $entityId Id of entity
     * @param string $locale Locale
     *
     * @return string Value fetched
     */
    public function getTranslationUnit(
        $entityType,
        $entityId,
        $locale
    )
    {
        // TODO: Implement getTranslationUnit() method.
    }
}
