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

namespace Elcodi\Component\EntityTranslator\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EntityTranslatorEntityEventListener
 */
class EntityTranslatorEntityEventListener
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected $container;

    /**
     * @var string
     *
     * Locale
     */
    protected $locale;

    /**
     * Construct method
     *
     * @param ContainerInterface $container Container
     * @param string             $locale    Locale
     */
    public function __construct(
        ContainerInterface $container,
        $locale
    )
    {
        $this->container = $container;
        $this->locale = $locale;
    }

    /**
     * Translate the entity to given locale
     *
     * @param LifecycleEventArgs $args Arguments
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this
            ->container
            ->get('elcodi.entity_translator')
            ->translate(
                $args->getEntity(),
                $this->locale
            );
    }
}
