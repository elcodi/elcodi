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

namespace Elcodi\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for a user edit profile form
 */
class CustomerType extends AbstractType
{

    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\UserBundle\Entity\Customer',
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
            ->add('email', 'email', array(
                'required' => true,
                'label' => '_Email',
            ))
            ->add('password', 'password', array(
                'label' => '_Password',
                'required' => false,
                'data' => ''
            ))
            ->add('firstname', null, array(
                'required' => true,
                'label' => '_Name',
            ))
            ->add('lastname', null, array(
                'required' => true,
                'label' => '_Surname',
            ))
            ->add('identity_document', null, array(
                'required' => false,
                'label' => '_IdentityDocument',
            ))
            ->add('enabled', 'checkbox', array(
                'label' => '_Enabled',
                'required' => false
            ))
            ->add('newsletter', 'checkbox', array(
                'label' => '_Newsletter',
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
        return 'elcodi_core_form_types_customer';
    }
}
