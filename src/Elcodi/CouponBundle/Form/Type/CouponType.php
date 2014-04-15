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

namespace Elcodi\CouponBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Elcodi\CouponBundle\ElcodiCouponTypes;

/**
 * Type for a coupon edit profile form
 */
class CouponType extends AbstractType
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
            'data_class' => 'Elcodi\CouponBundle\Entity\Coupon',
            'translation_domain' => 'core'
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
            ->add('code', null, array(
                'label' => '_Code',
                'required' => true
            ))
            ->add('name', null, array(
                'label' => '_Name',
                'required' => true
            ))
            ->add('type', 'choice', array(
                'choices'   => array(
                    ElcodiCouponTypes::TYPE_AMOUNT => '_Amount',
                    ElcodiCouponTypes::TYPE_PERCENT => '_Percent',
                ),
                'label' => '_Type',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('enforcement', 'choice', array(
                'choices'   => array(
                    ElcodiCouponTypes::ENFORCEMENT_MANUAL => '_Manual',
                    ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC => '_Automatic',
                ),
                'label' => '_Enforcement',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('value', null, array(
                'label' => '_Value',
                'required' => false
            ))
            ->add('minimumPurchaseAmount', 'money', array(
                'label' => '_Min_purchase_amount',
                'required' => false
            ))
            ->add('count', null, array(
                'label' => '_Count',
                'required' => true
            ))
            ->add('validFrom', 'date', array(
                'label' => '_Valid_from',
                'required' => true
            ))
            ->add('validTo', 'date', array(
                'label' => '_Valid_to',
                'required' => true
            ))
            ->add('enabled', 'checkbox', array(
                'label' => '_Enabled',
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
        return 'elcodi_core_form_types_coupon';
    }
}
