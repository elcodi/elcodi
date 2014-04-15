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
 * Type for a product edit profile form
 */
class ProductType extends AbstractType
{
    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     *
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Elcodi\ProductBundle\Entity\Product',
            'translation_domain' => 'admin',
        ));
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label'    => '_Name',
            ))
            ->add('slug', 'text', array(
                'required' => true,
                'label'    => '_Slug',
            ))
            ->add('description', 'textarea', array(
                'required' => true,
                'label'    => '_Description',
            ))
            ->add('shortDescription', 'textarea', array(
                'required' => true,
                'label'    => '_ShortDescription',
            ))
            ->add('showInHome', 'checkbox', array(
                'label' => '_ShowInHome',
            ))
            ->add('dimensions', 'text', array(
                'required' => false,
                'label'    => '_Dimensions',
            ))
            ->add('stock', 'integer', array(
                'required' => true,
                'label'    => '_Stock',
            ))
            ->add('price', 'number', array(
                'required'  => true,
                'precision' => 2,
                'label'     => '_Price',
            ))
            ->add('reducedPrice', 'number', array(
                'required'  => true,
                'precision' => 2,
                'label'     => '_ReducedPrice',
            ))
            ->add('manufacturer', 'entity', array(
                'class'    => 'ElcodiProductBundle:Manufacturer',
                'required' => false,
                'label'    => '_Manufacturer',
                'multiple' => false,
            ))
            ->add('principalCategory', 'entity', array(
                'class'    => 'ElcodiProductBundle:Category',
                'required' => false,
                'label'    => '_PrincipalCategory',
                'multiple' => false,
            ))
            ->add('categories', 'entity', array(
                'required' => false,
                'label'    => '_Categories',
                'multiple' => true,
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
        return 'elcodi_core_form_types_product';
    }
}
