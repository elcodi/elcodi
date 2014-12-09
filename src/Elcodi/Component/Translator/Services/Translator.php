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

use Elcodi\Component\Translator\Services\Interfaces\TranslationProviderInterface;
use Elcodi\Component\Translator\Services\Interfaces\TranslatorInterface;

/**
 * Class Translator
 */
class Translator implements TranslatorInterface
{
    /**
     * @var TranslationProviderInterface
     *
     * Translation Provider
     */
    protected $translationProvider;

    /**
     * @var array
     *
     * Configuration
     */
    protected $configuration;

    /**
     * Construct method
     *
     * @param TranslationProviderInterface $translationProvider Translation Provider
     * @param array                        $configuration       Configuration
     */
    public function __construct(
        TranslationProviderInterface $translationProvider,
        array $configuration
    )
    {
        $this->translationProvider = $translationProvider;
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
        $classNamespace = get_class($object);

        if (!array_key_exists($classNamespace, $this->configuration)) {
            return $object;
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
        $classNamespace = get_class($object);

        if (!array_key_exists($classNamespace, $this->configuration)) {
            return $object;
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

        $this
            ->translationProvider
            ->flushTranslations();

        return $this;
    }
}
