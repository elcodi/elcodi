<?php

/**
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

namespace Elcodi\CartBundle\Transformer;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\EventDispatcher\OrderEventDispatcher;
use Elcodi\CartBundle\Factory\OrderFactory;

/**
 * Class CartOrderTransformer
 *
 * This class is intended to create an Order given a Cart.
 * The scope of this class are both implementations
 *
 * Api Methods:
 *
 * * createOrderFromCart(AbstractCart) : AbstractOrder
 */
class CartOrderTransformer
{
    /**
     * @var OrderEventDispatcher
     *
     * OrderEventDispatcher
     */
    protected $orderEventDispatcher;

    /**
     * @var CartLineOrderLineTransformer
     *
     * CartLine to OrderLine transformer
     */
    protected $cartLineOrderLineTransformer;

    /**
     * @var OrderFactory
     *
     * Order factory
     */
    protected $orderFactory;

    /**
     * Construct method
     *
     * @param OrderEventDispatcher         $orderEventDispatcher         Order EventDispatcher
     * @param CartLineOrderLineTransformer $cartLineOrderLineTransformer CartLine to OrderLine transformer
     * @param OrderFactory                 $orderFactory                 OrderFactory
     */
    public function __construct(
        OrderEventDispatcher $orderEventDispatcher,
        CartLineOrderLineTransformer $cartLineOrderLineTransformer,
        OrderFactory $orderFactory
    )
    {
        $this->orderEventDispatcher = $orderEventDispatcher;
        $this->cartLineOrderLineTransformer = $cartLineOrderLineTransformer;
        $this->orderFactory = $orderFactory;
    }

    /**
     * This method creates a Order given a Cart.
     *
     * If cart has a order, this one is taken as order to be used, otherwise
     * new order will be created from the scratch
     *
     * This method dispatches these events
     *
     * ElcodiPurchaseEvents::ORDER_PRECREATED
     * ElcodiPurchaseEvents::ORDER_ONCREATED
     * ElcodiPurchaseEvents::ORDER_POSTCREATED
     *
     * @param CartInterface $cart Cart to create order from
     *
     * @return OrderInterface the created order
     */
    public function createOrderFromCart(CartInterface $cart)
    {
        $this
            ->orderEventDispatcher
            ->dispatchOrderPreCreatedEvent(
                $cart
            );

        $order = $cart->getOrder() instanceof OrderInterface
            ? $cart->getOrder()
            : $this->orderFactory->create();

        $cart->setOrder($order);

        $orderLines = $this
            ->cartLineOrderLineTransformer
            ->createOrderLinesByCartLines(
                $order,
                $cart->getCartLines()
            );

        $order
            ->setCustomer($cart->getCustomer())
            ->setCart($cart)
            ->setQuantity($cart->getQuantity())
            ->setProductAmount($cart->getProductAmount())
            ->setAmount($cart->getAmount())
            ->setOrderLines($orderLines);

        $this
            ->orderEventDispatcher
            ->dispatchOrderOnCreatedEvent(
                $cart,
                $order
            );

        return $order;
    }
}
