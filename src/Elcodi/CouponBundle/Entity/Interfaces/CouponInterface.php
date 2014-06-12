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

namespace Elcodi\CouponBundle\Entity\Interfaces;

use DateTime;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;

/**
 * CouponInterface
 */
interface CouponInterface
{
    /**
     * Set code
     *
     * @param string $code Code
     *
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object Self object
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
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object self Object
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
     * @return Object self Object
     */
    public function setPriority($priority);

    /**
     * Get priority
     *
     * @return integer Number this coupon has been priority
     */
    public function getPriority();

    /**
     * Set the minimum purchase amount that enables this coupon
     *
     * @param float $minimumPurchaseAmount
     *
     * @return Object self Object
     */
    public function setMinimumPurchaseAmount($minimumPurchaseAmount);

    /**
     * Get the minimum purchase amount that enabled this coupon
     *
     * @return float
     */
    public function getMinimumPurchaseAmount();

    /**
     * Set valid from
     *
     * @param DateTime $validFrom Valid from
     *
     * @return Object self Object
     */
    public function setValidFrom(DateTime $validFrom);

    /**
     * Get valid from
     *
     * @return DateTime
     */
    public function getValidFrom();

    /**
     * Set valid to
     *
     * @param DateTime $validTo Valid to
     *
     * @return Object self Object
     */
    public function setValidTo(DateTime $validTo);

    /**
     * Get valid to
     *
     * @return DateTime Valid to
     */
    public function getValidTo();

    /**
     * Set isEnabled
     *
     * @param boolean $enabled enabled value
     *
     * @return Object self Object
     */
    public function setEnabled($enabled);

    /**
     * Get if entity is enabled
     *
     * @return boolean
     */
    public function isEnabled();

    /**
     * Set locally created at value
     *
     * @param DateTime $createdAt CreatedAt value
     *
     * @return Object self Object
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Return created_at value
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set locally updated at value
     *
     * @param DateTime $updatedAt Updatedate value
     *
     * @return Object self Object
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * Return updated_at value
     *
     * @return DateTime
     */
    public function getUpdatedAt();
}
