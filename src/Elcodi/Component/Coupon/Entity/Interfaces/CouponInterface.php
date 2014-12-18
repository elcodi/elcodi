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

namespace Elcodi\Component\Coupon\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\ValidIntervalInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RulesAwareInterface;

/**
 * CouponInterface
 */
interface CouponInterface
    extends
    DateTimeInterface,
    EnabledInterface,
    ValidIntervalInterface,
    RulesAwareInterface
{
    /**
     * Set code
     *
     * @param string $code Code
     *
     * @return self
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Set name coupon name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set type
     *
     * @param int $type Type
     *
     * @return self
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return int Type
     */
    public function getType();

    /**
     * Sets Enforcement
     *
     * @param int $enforcement Enforcement
     *
     * @return self
     */
    public function setEnforcement($enforcement);

    /**
     * Get Enforcement
     *
     * @return int Enforcement
     */
    public function getEnforcement();

    /**
     * Set price
     *
     * @param MoneyInterface $amount Price
     *
     * @return self
     */
    public function setPrice(MoneyInterface $amount);

    /**
     * Get price
     *
     * @return MoneyInterface Price
     */
    public function getPrice();

    /**
     * Set discount
     *
     * @param int $discount Discount
     *
     * @return self
     */
    public function setDiscount($discount);

    /**
     * Get discount
     *
     * @return int discount
     */
    public function getDiscount();

    /**
     * Set absolute price
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return self
     */
    public function setAbsolutePrice(MoneyInterface $amount);

    /**
     * Get absolute price
     *
     * @return MoneyInterface Absolute Price
     */
    public function getAbsolutePrice();

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return self
     */
    public function setCount($count);

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount();

    /**
     * Set used
     *
     * @param integer $used
     *
     * @return self
     */
    public function setUsed($used);

    /**
     * Get used
     *
     * @return integer Number this coupon has been used
     */
    public function getUsed();

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return self
     */
    public function setPriority($priority);

    /**
     * Get priority
     *
     * @return integer Number this coupon has been priority
     */
    public function getPriority();

    /**
     * Set minimum purchase
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return self
     */
    public function setMinimumPurchase(MoneyInterface $amount);

    /**
     * Get minimum purchase
     *
     * @return MoneyInterface Absolute Price
     */
    public function getMinimumPurchase();

    /**
     * Increment used variable by one, and disables it if there are no more
     * available units
     *
     * @return self
     */
    public function makeUse();
}
