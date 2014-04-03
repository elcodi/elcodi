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

namespace Elcodi\CartBundle\Entity\Interfaces;

/**
 * Class PriceInterface
 */
interface PriceInterface
{
    /**
    * Get price products with tax
    *
    * @return float Products price with tax
    */
    public function getPriceProducts();

    /**
    * Set price products with tax
    *
    * @param float $priceProducts Products price without tax
    *
    * @return Object self Object
    */
    public function setPriceProducts($priceProducts);

    /**
    * Get price coupons with tax
    *
    * @return float Coupons price with tax
    */
    public function getPriceCoupons();

    /**
    * Set price coupons with tax
    *
    * @param float $priceCoupons Coupons price without tax
    *
    * @return Object self Object
    */
    public function setPriceCoupons($priceCoupons);

    /**
    * Get price coupons with tax
    *
    * @return float price with tax
    */
    public function getPrice();

    /**
    * Set price coupons with tax
    *
    * @param float $priceCoupons  price without tax
    *
    * @return Object self Object
    */
    public function setPrice($priceCoupons);
}
