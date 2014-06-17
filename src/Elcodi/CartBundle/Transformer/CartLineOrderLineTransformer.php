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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elcodi\CartBundle\EventDispatcher\OrderLineEventDispatcher;

use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Factory\OrderLineFactory;

/**
 * Class CartLineOrderLineTransformer
 *
 * Api Methods:
 *
 * * createOrderLinesByCartLines(OrderInterface, Collection) : Collection
 * * createOrderLineFromCartLine(OrderInterface, CartLineInterface) : OrderLineInterface
 */
class CartLineOrderLineTransformer
{
    /**
     * @var OrderLineEventDispatcher
     *
     * OrderLineEventDispatcher
     */
    protected $orderLineEventDispatcher;

    /**
     * @var OrderLineFactory
     *
     * OrderLine factory
     */
    protected $orderLineFactory;

    /**
     * Construct method
     *
     * @param OrderLineEventDispatcher $orderLineEventDispatcher Event dispatcher
     * @param OrderLineFactory         $orderLineFactory         OrderLineFactory
     */
    public function __construct(
        OrderLineEventDispatcher $orderLineEventDispatcher,
        OrderLineFactory $orderLineFactory
    )
    {
        $this->orderLineEventDispatcher = $orderLineEventDispatcher;
        $this->orderLineFactory = $orderLineFactory;
    }

    /**
     * Given a set of CartLines, return a set of OrderLines
     *
     * @param OrderInterface $order     Order
     * @param Collection     $cartLines Set of CartLines
     *
     * @return Collection Set of OrderLines
     */
    public function createOrderLinesByCartLines(
        OrderInterface $order,
        Collection $cartLines
    )
    {
        $orderLines = new ArrayCollection();

        /**
         * @var CartLineInterface $line
         */
        foreach ($cartLines as $cartLine) {

            $orderLines->add($this
                ->createOrderLineByCartLine(
                    $order,
                    $cartLine
                ));
        }

        return $orderLines;
    }

    /**
     * Given a cart line, creates a new order line
     *
     * @param OrderInterface    $order    Order
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return OrderLineInterface OrderLine created
     */
    public function createOrderLineByCartLine(
        OrderInterface $order,
        CartLineInterface $cartLine
    )
    {
        /**
         * @var OrderLineInterface $orderLine
         */
        $orderLine = $this->orderLineFactory->create();
        $orderLine
            ->setOrder($order)
            ->setProduct($cartLine->getProduct())
            ->setQuantity($cartLine->getQuantity())
            ->setProductAmount($cartLine->getProductAmount())
            ->setAmount($cartLine->getAmount());

        $this
            ->orderLineEventDispatcher
            ->dispatchOrderLineOnCreatedEvent(
                $order,
                $cartLine,
                $orderLine
            );

        return $orderLine;
    }
}
