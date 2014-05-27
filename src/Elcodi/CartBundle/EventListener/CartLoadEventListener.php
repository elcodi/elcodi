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

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Services\CartManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CartLoadEventListener
 */
class CartLoadEventListener
{
    /**
     * @var ContainerInterface
     *
     * container
     */
    protected $container;

    /**
     * Built method
     *
     * This is just a workaround, as container should not be injected
     * The reason is that if we inject the CartManager, a
     * ServiceCircularReferenceException is thrown by the DependencyInjection
     * Component.
     *
     * For this reason, this eventListener has been isolated
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * A cart is been loaded from database
     *
     * Must be loaded
     *
     * @param LifecycleEventArgs $args Arguments
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof CartInterface) {

            $this
                ->container
                ->get('elcodi.cart_manager')
                ->loadCart($entity);
        }
    }
}
