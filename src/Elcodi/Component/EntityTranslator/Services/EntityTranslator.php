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

namespace Elcodi\Component\EntityTranslator\Services;

use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;

/**
 * Class EntityTranslator.
 */
class EntityTranslator implements EntityTranslatorInterface
{
    /**
     * @var EntityTranslationProviderInterface
     *
     * Translation Provider
     */
    protected $entityTranslationProvider;

    /**
     * @var array
     *
     * Configuration
     */
    protected $configuration;

    /**
     * @var bool
     *
     * Fallback is enabled.
     *
     * If a field is required and the fallback flag is enabled, all translations
     * will not be required anymore, but just the translation with same language
     * than master
     */
    protected $fallback;

    /**
     * Construct method.
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Translation Provider
     * @param array                              $configuration             Configuration
     * @param bool                               $fallback                  Use fallback
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        array $configuration,
        $fallback
    ) {
        $this->entityTranslationProvider = $entityTranslationProvider;
        $this->configuration = $configuration;
        $this->fallback = $fallback;
    }

    /**
     * Translate object.
     *
     * @param object $object Object
     * @param string $locale Locale to be translated
     *
     * @return object Translated Object
     */
    public function translate($object, $locale)
    {
        $classStack = $this->getNamespacesFromClass(get_class($object));

        foreach ($classStack as $classNamespace) {
            if (!array_key_exists($classNamespace, $this->configuration)) {
                continue;
            }

            $configuration = $this->configuration[$classNamespace];
            $idGetter = $configuration['idGetter'];
            $entityId = $object->$idGetter();

            foreach ($configuration['fields'] as $fieldName => $fieldConfiguration) {
                $setter = $fieldConfiguration['setter'];
                $translation = $this
                    ->entityTranslationProvider
                    ->getTranslation(
                        $configuration['alias'],
                        $entityId,
                        $fieldName,
                        $locale
                    );

                if ($translation || !$this->fallback) {
                    $object->$setter($translation);
                }
            }
        }

        return $object;
    }

    /**
     * Saves object translations.
     *
     * $translations = array(
     *      'es' => array(
     *          'name' => 'Nombre del producto',
     *          'description' => 'Descripción del producto',
     *      ),
     *      'fr' => array(
     *          'name' => 'Nom du produit',
     *          'description' => 'Description du produit',
     *      ),
     * );
     *
     * @param object $object       Object
     * @param array  $translations Translations
     *
     * @return $this Self object
     */
    public function save($object, array $translations)
    {
        $classStack = $this->getNamespacesFromClass(get_class($object));

        foreach ($classStack as $classNamespace) {
            if (!array_key_exists($classNamespace, $this->configuration)) {
                continue;
            }

            $configuration = $this->configuration[$classNamespace];
            $idGetter = $configuration['idGetter'];
            $entityId = $object->$idGetter();

            foreach ($translations as $locale => $translation) {
                foreach ($configuration['fields'] as $fieldName => $fieldConfiguration) {
                    if (isset($translation[$fieldName])) {
                        $this
                            ->entityTranslationProvider
                            ->setTranslation(
                                $configuration['alias'],
                                $entityId,
                                $fieldName,
                                $translation[$fieldName],
                                $locale
                            );
                    }
                }
            }
        }

        $this
            ->entityTranslationProvider
            ->flushTranslations();

        return $this;
    }

    /**
     * Get all possible classes given an object.
     *
     * @param string $namespace Namespace
     *
     * @return string[] Set of classes and interfaces
     */
    protected function getNamespacesFromClass($namespace)
    {
        $classStack = [$namespace];
        $classStack = array_merge($classStack, class_parents($namespace));
        $classStack = array_merge($classStack, class_implements($namespace));

        return $classStack;
    }
}
