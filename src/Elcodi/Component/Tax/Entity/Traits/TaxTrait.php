<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 21/05/15
 * Time: 10:01
 */

namespace Elcodi\Component\Tax\Entity\Traits;

/**
 * Trait for entities that need to calculate taxes.
 *
 * Product, Variant, CartLine and OrderLine Cart and Orders entities usually will have this trait.
 *
 */
trait TaxTrait
{
    public function CalculateTaxAmount($price, $taxPercentage)
    {
            return (integer) round( ( $price * $taxPercentage/100 ) );
    }
}