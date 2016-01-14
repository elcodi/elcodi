<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Shipping\Entity;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class ShippingMethod.
 */
class ShippingMethod
{
    /**
     * @var string
     *
     * Identifier
     */
    protected $id;

    /**
     * @var string
     *
     * Carrier name
     */
    protected $carrierName;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var MoneyInterface
     *
     * Price
     */
    protected $price;

    /**
     * @param string         $id          Id
     * @param string         $carrierName Carrier name
     * @param string         $name        Name
     * @param string         $description Description
     * @param MoneyInterface $price       Price
     */
    public function __construct(
        $id,
        $carrierName,
        $name,
        $description,
        MoneyInterface $price
    ) {
        $this->id = $id;
        $this->carrierName = $carrierName;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * Get Id.
     *
     * @return string Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get CarrierName.
     *
     * @return string CarrierName
     */
    public function getCarrierName()
    {
        return $this->carrierName;
    }

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get Price.
     *
     * @return MoneyInterface Price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
