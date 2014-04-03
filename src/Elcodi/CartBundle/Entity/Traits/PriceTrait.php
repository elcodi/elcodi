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

namespace Elcodi\CartBundle\Entity\Traits;

/**
 * trait for add Entity enabled funct
 */
trait PriceTrait
{
    /**
     * @var float
     */
    protected $priceProducts = 0;

    /**
     * @var float
     */
    protected $priceCoupons = 0;

    /**
     * @var float
     */
    protected $price = 0;

    /**
    * Get price products with tax
    *
    * @return float Products price with tax
    */
    public function getPriceProducts()
    {
        return $this->priceProducts;
    }

    /**
    * Set price products with tax
    *
    * @param float $priceProducts Products price without tax
    *
    * @return Object self Object
    */
    public function setPriceProducts($priceProducts)
    {
        $this->priceProducts = $priceProducts;

        return $this;
    }

    /**
    * Get price coupons with tax
    *
    * @return float Coupons price with tax
    */
    public function getPriceCoupons()
    {
        return $this->priceCoupons;
    }

    /**
    * Set price coupons with tax
    *
    * @param float $priceCoupons Coupons price without tax
    *
    * @return Object self Object
    */
    public function setPriceCoupons($priceCoupons)
    {
        $this->priceCoupons = $priceCoupons;

        return $this;
    }

    /**
    * Get price coupons with tax
    *
    * @return float price with tax
    */
    public function getPrice()
    {
        return $this->price;
    }

    /**
    * Set price coupons with tax
    *
    * @param float $priceCoupons  price without tax
    *
    * @return Object self Object
    */
    public function setPrice($priceCoupons)
    {
        $this->price = $priceCoupons;

        return $this;
    }
}
