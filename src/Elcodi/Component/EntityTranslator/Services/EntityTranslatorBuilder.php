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

use Elcodi\Component\EntityTranslator\Exception\TranslationDefinitionException;
use Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;

/**
 * Class EntityTranslatorBuilder.
 */
class EntityTranslatorBuilder
{
    /**
     * @var array
     *
     * Configuration
     *
     * array(
     *      '\My\Namespace\Product' => array(
     *          'alias' => 'product',
     *          'idGetter' => 'getId',
     *          'fields' => array(
     *              'name' => array(
     *                  'setter' => 'setName',
     *                  'getter' => 'getName',
     *              ),
     *              'description' => array(
     *                  'setter' => 'setDescription',
     *                  'getter' => 'getDescription',
     *              ),
     *          ),
     *      ),
     * )
     */
    protected $configuration;

    /**
     * @var EntityTranslatorFactory
     *
     * Entity Translator factory
     */
    protected $entityTranslatorFactory;

    /**
     * @var EntityTranslationProviderInterface
     *
     * Translation Provider
     */
    protected $entityTranslationProvider;

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
     * @param EntityTranslatorFactory            $entityTranslatorFactory   Entity Translator Factory
     * @param array                              $configuration             Configuration
     * @param bool                               $fallback                  Fallback
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        EntityTranslatorFactory $entityTranslatorFactory,
        array $configuration,
        $fallback
    ) {
        $this->entityTranslationProvider = $entityTranslationProvider;
        $this->entityTranslatorFactory = $entityTranslatorFactory;
        $this->configuration = $configuration;
        $this->fallback = $fallback;
    }

    /**
     * Compile translator.
     *
     * @return EntityTranslatorInterface $translator
     */
    public function compile()
    {
        $translator = $this
            ->checkNamespace($this->configuration)
            ->checkAlias($this->configuration)
            ->checkMethods($this->configuration)
            ->createTranslator();

        return $translator;
    }

    /**
     * Check namespace.
     *
     * @param array $configuration Configuration
     *
     * @return $this Self object
     *
     * @throws TranslationDefinitionException Namespace invalid or not found
     */
    public function checkNamespace(array $configuration)
    {
        foreach ($configuration as $classNamespace => $classConfiguration) {
            if (class_exists($classNamespace) || interface_exists($classNamespace)) {
                return $this;
            }
        }

        throw new TranslationDefinitionException();
    }

    /**
     * Check alias.
     *
     * @param array $configuration Configuration
     *
     * @return $this Self object
     *
     * @throws TranslationDefinitionException Namespace invalid or not found
     */
    public function checkAlias(array $configuration)
    {
        foreach ($configuration as $classNamespace => $classConfiguration) {
            if (
                isset($classConfiguration['alias']) &&
                $classConfiguration['alias']
            ) {
                return $this;
            }
        }

        throw new TranslationDefinitionException();
    }

    /**
     * Check namespaces.
     *
     * @param array $configuration Configuration
     *
     * @return $this Self object
     *
     * @throws TranslationDefinitionException Namespace invalid or not found
     */
    public function checkMethods(array $configuration)
    {
        foreach ($configuration as $classNamespace => $classConfiguration) {
            if (
                !isset($classConfiguration['idGetter']) ||
                !method_exists($classNamespace, $classConfiguration['idGetter']) ||
                !isset($classConfiguration['fields']) ||
                !is_array($classConfiguration['fields'])
            ) {
                throw new TranslationDefinitionException();
            }

            foreach ($classConfiguration['fields'] as $fieldName => $fieldConfiguration) {
                if (
                    $fieldName &&
                    $fieldConfiguration &&
                    is_array($fieldConfiguration) &&
                    isset($fieldConfiguration['getter']) &&
                    method_exists($classNamespace, $fieldConfiguration['getter']) &&
                    isset($fieldConfiguration['setter']) &&
                    method_exists($classNamespace, $fieldConfiguration['setter'])
                ) {
                    continue;
                }

                throw new TranslationDefinitionException(
                    'Field ' . $classNamespace . ' not found, or methods [' . $fieldConfiguration['getter'] . ', ' . $fieldConfiguration['setter'] . '] not found inside the class'
                );
            }
        }

        return $this;
    }

    /**
     * Compile the translator and return an instance.
     *
     * @return EntityTranslatorInterface
     */
    public function createTranslator()
    {
        return $this
            ->entityTranslatorFactory
            ->create(
                $this->entityTranslationProvider,
                $this->configuration,
                $this->fallback
            );
    }
}
