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

use Elcodi\Component\Translator\Exception\TranslationDefinitionException;
use Elcodi\Component\Translator\Factory\TranslatorFactory;
use Elcodi\Component\Translator\Services\Interfaces\TranslatorInterface;

/**
 * Class TranslatorBuilder
 */
class TranslatorBuilder
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
     * @var TranslatorFactory
     *
     * Translator factory
     */
    protected $translatorFactory;

    /**
     * @var TranslationProvider
     *
     * Translation Provider
     */
    protected $translationProvider;

    /**
     * Construct method
     *
     * @param TranslationProvider $translationProvider Translation Provider
     * @param TranslatorFactory   $translatorFactory   Translator Factory
     * @param array               $configuration       Configuration
     */
    public function __construct(
        TranslationProvider $translationProvider,
        TranslatorFactory $translatorFactory,
        array $configuration
    )
    {
        $this->translationProvider = $translationProvider;
        $this->translatorFactory = $translatorFactory;
        $this->configuration = $configuration;
    }

    /**
     * Compile translator
     *
     * @return TranslatorInterface $translator
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
     * @return TranslatorInterface
     */
    public function createTranslator()
    {
        return $this
            ->translatorFactory
            ->create(
                $this->translationProvider,
                $this->configuration
            );
    }
}
