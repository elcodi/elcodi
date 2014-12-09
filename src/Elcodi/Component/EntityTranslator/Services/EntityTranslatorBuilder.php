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

use Elcodi\Component\EntityTranslator\Exception\TranslationDefinitionException;
use Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;

/**
 * Class EntityTranslatorBuilder
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
     * @var EntityTranslationProvider
     *
     * Translation Provider
     */
    protected $entityTranslationProvider;

    /**
     * Construct method
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Translation Provider
     * @param EntityTranslatorFactory            $entityTranslatorFactory   Entity Translator Factory
     * @param array                              $configuration             Configuration
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        EntityTranslatorFactory $entityTranslatorFactory,
        array $configuration
    )
    {
        $this->translationProvider = $entityTranslationProvider;
        $this->entityTranslatorFactory = $entityTranslatorFactory;
        $this->configuration = $configuration;
    }

    /**
     * Compile translator
     *
     * @return EntityTranslatorInterface $translator
     */
    public function compile()
    {
        $translator = $this
            ->checkNamespace($this->configuration)
            ->checkAlias($this->configuration)
            ->checkMethods($this->configuration)
            ->createTranslator($this->configuration);

        return $translator;
    }

    /**
     * Check namespace
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
     *
     * @throws TranslationDefinitionException Namespace invalid or not found
     */
    public function checkNamespace(array $configuration)
    {
        foreach ($configuration as $classNamespace => $classConfiguration) {

            if (class_exists($classNamespace)) {
                return $this;
            }
        }

        throw new TranslationDefinitionException();
    }

    /**
     * Check alias
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
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
     * Check namespaces
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
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

                throw new TranslationDefinitionException();
            }
        }

        return $this;
    }

    /**
     * Compile the translator and return an instance
     *
     * @return EntityTranslatorInterface
     */
    public function createTranslator()
    {
        return $this
            ->entityTranslatorFactory
            ->create(
                $this->translationProvider,
                $this->configuration
            );
    }
}
