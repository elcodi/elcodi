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

namespace Elcodi\Component\Coupon\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Core\Entity\Interfaces\ValidIntervalInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Interface CouponInterface.
 */
interface CouponInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface,
    ValidIntervalInterface
{
    /**
     * Set code.
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code);

    /**
     * Get code.
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Set name coupon name.
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set type.
     *
     * @see ElcodiCouponTypes::TYPE_AMOUNT
     * @see ElcodiCouponTypes::TYPE_PERCENT
     *
     * @param int $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get type.
     *
     * @return int Type
     */
    public function getType();

    /**
     * Sets Enforcement.
     *
     * @see ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC
     * @see ElcodiCouponTypes::ENFORCEMENT_MANUAL
     *
     * @param int $enforcement Enforcement
     *
     * @return $this Self object
     */
    public function setEnforcement($enforcement);

    /**
     * Get Enforcement.
     *
     * @return int Enforcement
     */
    public function getEnforcement();

    /**
     * Set price.
     *
     * @param MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(MoneyInterface $amount);

    /**
     * Get price.
     *
     * @return MoneyInterface Price
     */
    public function getPrice();

    /**
     * Set discount.
     *
     * @param int $discount Discount
     *
     * @return $this Self object
     */
    public function setDiscount($discount);

    /**
     * Get discount.
     *
     * @return int discount
     */
    public function getDiscount();

    /**
     * Set absolute price.
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return $this Self object
     */
    public function setAbsolutePrice(MoneyInterface $amount);

    /**
     * Get absolute price.
     *
     * @return MoneyInterface Absolute Price
     */
    public function getAbsolutePrice();

    /**
     * Get Value.
     *
     * @return string Value
     */
    public function getValue();

    /**
     * Sets Value.
     *
     * @param string $value Value
     *
     * @return $this Self object
     */
    public function setValue($value);

    /**
     * Set count.
     *
     * @param int $count
     *
     * @return $this Self object
     */
    public function setCount($count);

    /**
     * Get count.
     *
     * @return int
     */
    public function getCount();

    /**
     * Set used.
     *
     * @param int $used
     *
     * @return $this Self object
     */
    public function setUsed($used);

    /**
     * Get used.
     *
     * @return int Number this coupon has been used
     */
    public function getUsed();

    /**
     * Set priority.
     *
     * @param int $priority
     *
     * @return $this Self object
     */
    public function setPriority($priority);

    /**
     * Get priority.
     *
     * @return int Number this coupon has been priority
     */
    public function getPriority();

    /**
     * Set minimum purchase.
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return $this Self object
     */
    public function setMinimumPurchase(MoneyInterface $amount);

    /**
     * Get minimum purchase.
     *
     * @return MoneyInterface Absolute Price
     */
    public function getMinimumPurchase();

    /**
     * Get if this coupon can be used together with another coupon.
     *
     * @return int
     */
    public function getStackable();

    /**
     * Set if this coupon can be used together with another coupon.
     *
     * @param int $stackable
     *
     * @return $this Self object
     */
    public function setStackable($stackable);

    /**
     * Set rule Rule to check for applicability.
     *
     * @param RuleInterface $rule New rule
     *
     * @return $this Self object
     */
    public function setRule(RuleInterface $rule);

    /**
     * Get rule to check for applicability.
     *
     * @return RuleInterface Current rule
     */
    public function getRule();

    /**
     * Increment used variable by one, and disables it if there are no more
     * available units.
     *
     * @return $this Self object
     */
    public function makeUse();
}
