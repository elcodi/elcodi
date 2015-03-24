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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\EntityTranslator\Form\Type;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormConfigInterface;

use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class TranslatableFieldType
 */
class TranslatableFieldType extends AbstractType
{
    /**
     * @var EntityTranslationProviderInterface
     *
     * Entity Translation provider
     */
    protected $entityTranslationProvider;

    /**
     * @var FormConfigInterface
     *
     * Form Config
     */
    protected $formConfig;

    /**
     * @var Object
     *
     * Entity
     */
    protected $entity;

    /**
     * @var string
     *
     * Field name
     */
    protected $fieldName;

    /**
     * @var array
     *
     * Entity configuration
     */
    protected $entityConfiguration;

    /**
     * @var array
     *
     * Field configuration
     */
    protected $fieldConfiguration;

    /**
     * @var Collection
     *
     * Locales
     */
    protected $locales;

    /**
     * @var string
     *
     * Master locale
     */
    protected $masterLocale;

    /**
     * @var boolean
     *
     * Fallback is enabled.
     *
     * If a field is required and the fallback flag is enabled, all translations
     * will not be required anymore, but just the translation with same language
     * than master
     */
    protected $fallback;

    /**
     * Construct
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Entity Translation provider
     * @param FormConfigInterface                $formConfig                Form config
     * @param Object                             $entity                    Entity
     * @param string                             $fieldName                 Field name
     * @param array                              $entityConfiguration       Entity configuration
     * @param array                              $fieldConfiguration        Field configuration
     * @param array                              $locales                   Locales
     * @param string                             $masterLocale              Master locale
     * @param boolean                            $fallback                  Fallback
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        FormConfigInterface $formConfig,
        $entity,
        $fieldName,
        array $entityConfiguration,
        array $fieldConfiguration,
        array $locales,
        $masterLocale,
        $fallback
    ) {
        $this->translationProvider = $entityTranslationProvider;
        $this->formConfig = $formConfig;
        $this->entity = $entity;
        $this->fieldName = $fieldName;
        $this->entityConfiguration = $entityConfiguration;
        $this->fieldConfiguration = $fieldConfiguration;
        $this->locales = $locales;
        $this->masterLocale = $masterLocale;
        $this->fallback = $fallback;
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityAlias = $this->entityConfiguration['alias'];
        $entityIdGetter = $this->entityConfiguration['idGetter'];

        $fieldOptions = $this
            ->formConfig
            ->getOptions();

        $fieldType = $this
            ->formConfig
            ->getType()
            ->getName();

        foreach ($this->locales as $locale) {
            $translatedFieldName = $locale . '_' . $this->fieldName;

            $entityId = $this->entity->$entityIdGetter();
            $translationData = $entityId
                ? $this
                    ->translationProvider
                    ->getTranslation(
                        $entityAlias,
                        $entityId,
                        $this->fieldName,
                        $locale
                    )
                : '';

            $builder->add($translatedFieldName, $fieldType, [
                'required' => isset($fieldOptions['required'])
                    ? $this->evaluateRequired(
                        $fieldOptions['required'],
                        $locale
                    )
                    : false,
                'mapped'   => false,
                'label'    => $fieldOptions['label'],
                'data'     => $translationData,
            ]);
        }
    }

    /**
     * Check the require value
     *
     * @param boolean $required Form field is required
     * @param string  $locale   Locale
     *
     * @return boolean translatable field is required
     */
    public function evaluateRequired($required, $locale)
    {
        return (boolean) $required
            ? !$this->fallback || ($this->masterLocale === $locale)
            : false;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'translatable_field';
    }
}
