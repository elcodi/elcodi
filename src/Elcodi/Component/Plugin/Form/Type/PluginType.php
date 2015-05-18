<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Plugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class PluginType
 */
class PluginType extends AbstractType
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Construct
     *
     * @param Plugin $plugin Plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = $this
            ->plugin
            ->getFields();

        foreach ($fields as $fieldName => $field) {
            $builder
                ->remove($fieldName)
                ->add($fieldName, $field['type'], [
                    'label'    => $field['label'],
                    'data'     => $field['data'],
                    'required' => $field['required'],
                    'attr'     => $field['attr'],
                ]);
        }

        $builder->add('save', 'submit');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'elcodi_form_type_plugin';
    }
}
