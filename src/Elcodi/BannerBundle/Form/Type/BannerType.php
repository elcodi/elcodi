<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\BannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for a attributetype edit form
 */
class BannerType extends AbstractType
{
    /**
     * Default form options
     * @param OptionsResolverInterface $resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\BannerBundle\Entity\Banner',
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
                'required'  =>  true,
                'label' => '_Name',
            ))
            ->add('description', 'textarea', array(
                'required'  =>  false,
                'label' => '_Description',
            ))
            ->add('url', 'text', array(
                'required'  =>  false,
                'label' => '_Url',
            ))
            ->add('htmlClass', 'text', array(
                'required'  =>  false,
                'label' => '_Html_class',
            ))
            ->add('position', 'integer', array(
                'required'  =>  false,
                'label' => '_Position',
            ))
            ->add('bannerZones', 'entity', array(
                'class'     =>  'ElcodiBannerBundle:BannerZone',
                'required'  =>  false,
                'multiple'  =>  true,
                'by_reference'  =>  false,
                'label' => '_Banner_zones',
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_core_form_types_banner';
    }
}
