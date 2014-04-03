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

namespace Elcodi\CurrencyBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\CouponBundle\Entity\Coupon;

/**
 * Type for a coupon edit profile form
 */
class CurrencyType extends AbstractType
{

    /**
     * Default form options
     *
     * @param OptionsResolverInterface $resolver Resolver
     *
     * @return array With the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcodi\CurrencyBundle\Entity\Currency',
            'translation_domain' => 'admin'
        ));
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     *
     * @return array
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iso', null, array(
                'label' => '_Iso',
                'required' => true
            ))
            ->add('symbol', null, array(
                'label' => '_Symbol',
                'required' => true
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_core_form_types_currency';
    }
}