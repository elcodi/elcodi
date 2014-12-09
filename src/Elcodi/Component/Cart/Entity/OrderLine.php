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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Abstracts\AbstractLine;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Resolver\DefaultPurchasableResolver;
use Elcodi\Component\Cart\Resolver\Interfaces\PurchasableResolverInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Traits\StateLinesTrait;

/**
 * OrderLine
 *
 * This entity is just an extension of existant order line with some additional
 * parameters
 */
class OrderLine extends AbstractLine implements OrderLineInterface
{
    use StateLinesTrait;

    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return $this self Object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Returns a purchasable resolver
     *
     * A purchasable resolver is needed so that classes in the
     * hierarchy can plug-in specific logic when adding a
     * Purchasable to an AbstractLine
     *
     * Here we will return teh Default resolver
     *
     * @return PurchasableResolverInterface
     */
    protected function getPurchasableResolver()
    {
        return new DefaultPurchasableResolver($this);
    }
}
