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

use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;

/**
 * Class EntityTranslator
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
     * Construct method
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Translation Provider
     * @param array                              $configuration             Configuration
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        array $configuration
    )
    {
        $this->translationProvider = $entityTranslationProvider;
        $this->configuration = $configuration;
    }

    /**
     * Translate object
     *
     * @param Object $object Object
     * @param string $locale Locale to be translated
     *
     * @return Object Translated Object
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
                    ->translationProvider
                    ->getTranslation(
                        $configuration['alias'],
                        $entityId,
                        $fieldName,
                        $locale
                    );

                $object->$setter($translation);
            }
        }

        return $object;
    }

    /**
     * Saves object translations
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
     * @param Object $object       Object
     * @param array  $translations Translations
     *
     * @return $this self Object
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
                            ->translationProvider
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
            ->translationProvider
            ->flushTranslations();

        return $this;
    }

    /**
     * Get all possible classes given an object
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
