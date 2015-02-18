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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Shipping\Entity;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Entity\Traits\ShippingPriceRangeTrait;
use Elcodi\Component\Shipping\Entity\Traits\ShippingWeightRangeTrait;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;

/**
 * Class ShippingRange
 */
class ShippingRange implements ShippingRangeInterface
{
    use ShippingPriceRangeTrait,
        ShippingWeightRangeTrait,
        IdentifiableTrait,
        EnabledTrait;

    /**
     * @var CarrierInterface
     *
     * carrier
     */
    protected $carrier;

    /**
     * @var string
     *
     * name of the range
     */
    protected $name;

    /**
     * @var ZoneInterface
     *
     * fromZone
     */
    protected $fromZone;

    /**
     * @var ZoneInterface
     *
     * toZone
     */
    protected $toZone;

    /**
     * @var float
     *
     * Product price amount
     */
    protected $priceAmount;

    /**
     * @var CurrencyInterface
     *
     * Product price currency
     */
    protected $priceCurrency;

    /**
     * @var string
     *
     * Type
     */
    protected $type;

    /**
     * Get Carrier
     *
     * @return CarrierInterface Carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * Sets Carrier
     *
     * @param CarrierInterface $carrier Carrier
     *
     * @return $this Self object
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get FromZone
     *
     * @return ZoneInterface FromZone
     */
    public function getFromZone()
    {
        return $this->fromZone;
    }

    /**
     * Sets FromZone
     *
     * @param ZoneInterface $fromZone FromZone
     *
     * @return $this Self object
     */
    public function setFromZone($fromZone)
    {
        $this->fromZone = $fromZone;

        return $this;
    }

    /**
     * Get ToZone
     *
     * @return ZoneInterface ToZone
     */
    public function getToZone()
    {
        return $this->toZone;
    }

    /**
     * Sets ToZone
     *
     * @param ZoneInterface $toZone ToZone
     *
     * @return $this Self object
     */
    public function setToZone($toZone)
    {
        $this->toZone = $toZone;

        return $this;
    }

    /**
     * Set price
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(MoneyInterface $amount)
    {
        $this->priceAmount = $amount->getAmount();
        $this->priceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price
     *
     * @return MoneyInterface Price
     */
    public function getPrice()
    {
        return Money::create(
            $this->priceAmount,
            $this->priceCurrency
        );
    }

    /**
     * Get Type
     *
     * @return mixed Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Type
     *
     * @param mixed $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
