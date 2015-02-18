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

namespace Elcodi\Component\Coupon\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Core\Entity\Traits\ValidIntervalTrait;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Coupon
 */
class Coupon implements CouponInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait,
        ValidIntervalTrait;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var integer
     *
     * Type
     */
    protected $type;

    /**
     * @var integer
     *
     * Enforcement type
     */
    protected $enforcement;

    /**
     * @var integer
     *
     * Price amount
     */
    protected $priceAmount = 0;

    /**
     * @var CurrencyInterface
     *
     * Price currency
     */
    protected $priceCurrency;

    /**
     * @var integer
     *
     * Discount
     */
    protected $discount = 0;

    /**
     * @var integer
     *
     * Absolute price amount
     */
    protected $absolutePriceAmount = 0;

    /**
     * @var CurrencyInterface
     *
     * Absolute price currency
     */
    protected $absolutePriceCurrency;

    /**
     * @var integer
     *
     * Count
     */
    protected $count;

    /**
     * @var integer
     *
     * Used times
     */
    protected $used;

    /**
     * @var integer
     *
     * Priority
     */
    protected $priority;

    /**
     * @var float
     *
     * Minimum purchase amount
     */
    protected $minimumPurchaseAmount;

    /**
     * @var CurrencyInterface
     *
     * Minimum purchase currency
     */
    protected $minimumPurchaseCurrency;

    /**
     * @var RuleInterface
     *
     * Rule to check to be applicable
     */
    protected $rule;

    /**
     * Set code
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name coupon name
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Enforcement
     *
     * @param integer $enforcement Enforcement
     *
     * @return $this Self object
     */
    public function setEnforcement($enforcement)
    {
        $this->enforcement = $enforcement;

        return $this;
    }

    /**
     * Get Enforcement
     *
     * @return integer Enforcement
     */
    public function getEnforcement()
    {
        return $this->enforcement;
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
     * Set discount
     *
     * @param integer $discount Discount
     *
     * @return $this Self object
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set absolute price
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return $this Self object
     */
    public function setAbsolutePrice(MoneyInterface $amount)
    {
        $this->absolutePriceAmount = $amount->getAmount();
        $this->absolutePriceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get absolute price
     *
     * @return MoneyInterface Absolute Price
     */
    public function getAbsolutePrice()
    {
        return Money::create(
            $this->absolutePriceAmount,
            $this->absolutePriceCurrency
        );
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return $this Self object
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set used
     *
     * @param integer $used
     *
     * @return $this Self object
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return integer Number this coupon has been used
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return $this Self object
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer Number this coupon has been priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set minimum purchase
     *
     * @param MoneyInterface $amount Absolute Price
     *
     * @return $this Self object
     */
    public function setMinimumPurchase(MoneyInterface $amount)
    {
        $this->minimumPurchaseAmount = $amount->getAmount();
        $this->minimumPurchaseCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get minimum purchase
     *
     * @return MoneyInterface Absolute Price
     */
    public function getMinimumPurchase()
    {
        return Money::create(
            $this->minimumPurchaseAmount,
            $this->minimumPurchaseCurrency
        );
    }

    /**
     * Set rule Rule to check for applicability
     *
     * @param RuleInterface $rule New rule
     *
     * @return $this Self object
     */
    public function setRule(RuleInterface $rule = null)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule to check for applicability
     *
     * @return RuleInterface Current rule
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * String representation of Coupon
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Increment used variable by one, and disables it if there are no more
     * available units
     *
     * @return $this Self object
     */
    public function makeUse()
    {
        ++$this->used;

        if ($this->count > 0 && $this->count <= $this->used) {
            $this->enabled = false;
        }

        return $this;
    }
}
