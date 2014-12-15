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
     * Construct
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Entity Translation provider
     * @param FormConfigInterface                $formConfig                Form config
     * @param Object                             $entity                    Entity
     * @param string                             $fieldName                 Field name
     * @param array                              $entityConfiguration       Entity configuration
     * @param array                              $fieldConfiguration        Field configuration
     * @param Collection                         $locales                   Locales
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        FormConfigInterface $formConfig,
        $entity,
        $fieldName,
        array $entityConfiguration,
        array $fieldConfiguration,
        Collection $locales
    )
    {
        $this->translationProvider = $entityTranslationProvider;
        $this->formConfig = $formConfig;
        $this->entity = $entity;
        $this->fieldName = $fieldName;
        $this->entityConfiguration = $entityConfiguration;
        $this->fieldConfiguration = $fieldConfiguration;
        $this->locales = $locales;
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

            $builder->add($translatedFieldName, $fieldType, array(
                'required' => $fieldOptions['required'],
                'mapped'   => false,
                'label'    => 'Translation of ' . $this->fieldName . ' for ' . $locale,
                'data'     => $translationData,
            ));
        }
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
