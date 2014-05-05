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

namespace Elcodi\ReferralProgramBundle\Form\Type;

use Elcodi\ReferralProgramBundle\ElcodiReferralProgramRuleTypes;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ReferralRuleType
 */
class ReferralRuleType extends AbstractType
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
            'data_class'         => 'Elcodi\ReferralProgramBundle\Entity\ReferralRule',
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
            ->add('referrerType', 'choice', array(
                'choices'     => array(
                    ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON    => ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER       => ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE => ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE,
                ),
                'empty_value' => false,
            ))
            ->add('referrerCoupon', 'entity', array(
                'class'         => 'ElcodiCouponBundle:Coupon',
                'query_builder' => function (EntityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('c')
                            ->where('c.enabled = :enabled')
                            ->andWhere('c.deleted = :deleted')
                            ->setParameters(array(
                                'enabled' => true,
                                'deleted' => false,
                            ));
                },
                'empty_value'   => 'No Coupon',
                'property'      => 'code',
                'label'         => '_Coupon',
                'multiple'      => false,
                'required'      => false,
            ))
            ->add('invitedType', 'choice', array(
                'choices'     => array(
                    ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON    => ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER       => ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE => ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE,
                ),
                'empty_value' => false,
            ))
            ->add('invitedCoupon', 'entity', array(
                'class'         => 'ElcodiCouponBundle:Coupon',
                'query_builder' => function (EntityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('c')
                            ->where('c.enabled = :enabled')
                            ->andWhere('c.deleted = :deleted')
                            ->setParameters(array(
                                'enabled' => true,
                                'deleted' => false,
                            ));
                },
                'empty_value'   => 'No Coupon',
                'property'      => 'code',
                'label'         => '_Coupon',
                'multiple'      => false,
                'required'      => false,
            ))
            ->add('validFrom', 'datetime', array(
                'required' => true,
            ))
            ->add('validTo', 'datetime', array(
                'required' => false,
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_core_form_types_referralrule';
    }
}
