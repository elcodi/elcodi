<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CouponBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\CoreBundle\Entity\Traits\ValidIntervalTrait;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;

/**
 * Coupon
 */
class Coupon extends AbstractEntity implements CouponInterface
{
    use DateTimeTrait, EnabledTrait, ValidIntervalTrait;

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
     * @var int
     *
     * Type
     */
    protected $type;

    /**
     * @var int
     *
     * Enforcement type
     */
    protected $enforcement;

    /**
     * @var float
     *
     * Value
     */
    protected $value;

    /**
     * @var float
     *
     * Absolute value
     */
    protected $absoluteValue;

    /**
     * @var float
     *
     * Count
     */
    protected $count;

    /**
     * @var int
     *
     * Used times
     */
    protected $used;

    /**
     * @var float
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
     * Set code
     *
     * @param string $code Code
     *
     * @return Coupon self Object
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
     * @return Coupon self Object
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
     * @param int $type Type
     *
     * @return Coupon self Object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Enforcement
     *
     * @param int $enforcement Enforcement
     *
     * @return Coupon Self object
     */
    public function setEnforcement($enforcement)
    {
        $this->enforcement = $enforcement;

        return $this;
    }

    /**
     * Get Enforcement
     *
     * @return int Enforcement
     */
    public function getEnforcement()
    {
        return $this->enforcement;
    }

    /**
     * Set value
     *
     * @param int $value Value
     *
     * @return Coupon self Object
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set absoluteValue
     *
     * @param int $absoluteValue Absolute Value
     *
     * @return Coupon self Object
     */
    public function setAbsoluteValue($absoluteValue)
    {
        $this->absoluteValue = $absoluteValue;

        return $this;
    }

    /**
     * Get value
     *
     * @return int Absolute Value
     */
    public function getAbsoluteValue()
    {
        return $this->absoluteValue;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return Coupon self Object
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
     * @return Coupon self Object
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
     * @return Coupon self Object
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
     * Set the minimum purchase amount that enables this coupon
     *
     * @param float $minimumPurchaseAmount
     *
     * @return Coupon self Object
     */
    public function setMinimumPurchaseAmount($minimumPurchaseAmount)
    {
        $this->minimumPurchaseAmount = $minimumPurchaseAmount;

        return $this;
    }

    /**
     * Get the minimum purchase amount that enabled this coupon
     *
     * @return float
     */
    public function getMinimumPurchaseAmount()
    {
        return $this->minimumPurchaseAmount;
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
}
