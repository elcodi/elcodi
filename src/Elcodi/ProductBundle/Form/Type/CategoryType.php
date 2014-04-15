<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for a category edit profile form
 */
class CategoryType extends AbstractType
{
    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\ProductBundle\Entity\Category',
            'translation_domain' => 'admin'
        ));
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('parent', 'entity', array(
                'class' => 'ElcodiProductBundle:Category',
                'label' => '_Parent',
                'multiple' => false,
                'required' => false,
                'empty_value' => '--- Root ---',
            ))
            ->add('position', 'number', array(
                'label' => '_Position',
                'required' => false
            ))
            ->add('root', 'checkbox', array(
                'label' => '_Principal',
                'required' => false
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label'    => '_Meta_title',
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => false,
                'label'    => '_Meta_description',
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label'    => '_Meta_keywords',
            ))
            ->add('enabled', 'checkbox', array(
                'label'    => '_Enabled',
                'required' => false
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_core_form_types_category';
    }
}
