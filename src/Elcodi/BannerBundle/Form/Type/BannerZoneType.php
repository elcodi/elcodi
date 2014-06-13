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

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Type for a bannerzone edit form
 */
class BannerZoneType extends AbstractType
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
            'data_class' => 'Elcodi\BannerBundle\Entity\BannerZone',
        ));
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     *
     * @return queries result
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => '_Name',
                'required' => true,
            ))
            ->add('code', 'text', array(
                'label' => '_Code',
                'required'  =>  false,
            ))
            ->add('width', 'number', array(
                'label' => '_Width',
                'required'  =>  true,
            ))
            ->add('height', 'number', array(
                'label' => '_Height',
                'required'  =>  true,
            ))
            ->add('language', 'entity', array(
                'class'     =>  'ElcodiCoreBundle:Language',
                'required'  =>  false,
                'multiple'  =>  false,
                'label' => '_Language',
            ))
            ->add('htmlClass', 'text', array(
                'required'  =>  false,
                'label' => '_Html_class',
            ))
            ->add('bannerHtmlClass', 'text', array(
                'required'  =>  false,
                'label' => '_Banner_html_class',
            ))
            ->add('banners', 'entity', array(
                'class'     =>  'ElcodiBannerBundle:Banner',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('o');
                    $qb->select('o')
                        ->where('o.enabled = :enabled')
                        ->andWhere('o.deleted = :deleted')
                        ->setParameters(array(
                            'enabled'   =>  true,
                            'deleted'   =>  false,
                        ))
                        ->addOrderBy('o.name', 'ASC');

                    return $qb;
                },
                'required'  =>  false,
                'multiple'  =>  true,
                'label' => '_Banners',
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_core_form_types_bannerzone';
    }
}
