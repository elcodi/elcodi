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

namespace Elcodi\CartBundle\Tests\Functional\Services;

use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Services\OrderLineManager;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Tests OrderLineManager class
 */
class OrderLineManagerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.cart.services.order_line_manager';
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiUserBundle',
        );
    }

    /**
     * Tests Order state change when multiple OrderLines change states
     */
    public function testToState()
    {
        /**
         * @var OrderLineManager   $orderLineManager
         * @var OrderInterface     $order
         * @var OrderLineInterface $orderLine
         * @var OrderLineInterface $secondaryOrderLine
         */
        $orderLineManager = $this->container->get('elcodi.core.cart.services.order_line_manager');
        $order = $this->container->get('elcodi.core.cart.factory.order')->create();
        $orderLine = $this->container->get('elcodi.core.cart.factory.order_line')->create()->setQuantity(1);
        $secondaryOrderLine = $this->container->get('elcodi.core.cart.factory.order_line')->create()->setQuantity(1);

        $product1 = $this->container->get('elcodi.core.product.factory.product')->create()->setName("p1")->setSlug("p1");
        $orderLine->setProduct($product1);

        $product2 = $this->container->get('elcodi.core.product.factory.product')->create()->setName("p2")->setSlug("p2");
        $secondaryOrderLine->setProduct($product2);

        $customer = $this->manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $order->setCustomer($customer);

        $this->manager->persist($order);
        $this->manager->persist($product1);
        $this->manager->persist($product2);
        $this->manager->flush();

        $order->addOrderLine($orderLine);
        $orderLine->setOrder($order);
        $order->addOrderLine($secondaryOrderLine);
        $secondaryOrderLine->setOrder($order);
        $orderLineManager->toState($order, $orderLine, 'accepted');
        $this->assertEquals('new', $order->getLastOrderHistory()->getState());
        $orderLineManager->toState($order, $secondaryOrderLine, 'accepted');
        $this->assertEquals('accepted', $order->getLastOrderHistory()->getState());
    }
}
