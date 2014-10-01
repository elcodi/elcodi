<?php

/**
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

namespace Elcodi\Component\Shipping\Resolver;

use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingResolverTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierRangeInterface;

/**
 * Class CarrierResolver
 */
class CarrierResolver
{
    /**
     * @var CurrencyConverter
     *
     * currencyConverter
     */
    protected $currencyConverter;

    /**
     * @var integer
     *
     * Carrier resolver type
     */
    protected $carrierResolverStrategy;

    /**
     * Construct method
     *
     * @param CurrencyConverter $currencyConverter       Currency Converter
     * @param integer           $carrierResolverStrategy Carrier Resolver Type
     */
    public function __construct(
        CurrencyConverter $currencyConverter,
        $carrierResolverStrategy)
    {
        $this->currencyConverter = $currencyConverter;
        $this->carrierResolverStrategy = $carrierResolverStrategy;
    }

    /**
     * Resolve valid carrier given a set of them
     *
     * @param CarrierRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierRangeInterface[] Valid carrier ranges
     */
    public function resolveCarrierRanges(array $carrierRanges)
    {
        $validCarrierRanges = array();

        switch ($this->carrierResolverStrategy) {

            case ElcodiShippingResolverTypes::CARRIER_RESOLVER_ALL:
                $validCarrierRanges = $carrierRanges;
                break;

            case ElcodiShippingResolverTypes::CARRIER_RESOLVER_LOWEST:
                $validCarrierRanges = array($this->getCarrierRangeWithLowestPrice($carrierRanges));
                break;

            case ElcodiShippingResolverTypes::CARRIER_RESOLVER_HIGHEST:
                $validCarrierRanges = array($this->getCarrierRangeWithHighestPrice($carrierRanges));
                break;
        }

        return $validCarrierRanges;
    }

    /**
     * Get the CarrierRange with the lowest price
     *
     * @param CarrierRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierRangeInterface Lowest price CarrierRange
     */
    protected function getCarrierRangeWithLowestPrice(array $carrierRanges)
    {
        /**
         * @var CarrierRangeInterface $lowestPriceCarrierRange
         */
        $lowestPriceCarrierRange = null;

        foreach ($carrierRanges as $carrierRange) {

            $carrierRangePrice = $carrierRange->getPrice();

            if ($lowestPriceCarrierRange instanceof CarrierRangeInterface) {

                if ($carrierRangePrice
                    ->isLessThan(
                        $this
                            ->currencyConverter
                            ->convertMoney(
                                $lowestPriceCarrierRange->getPrice(),
                                $carrierRangePrice->getCurrency()
                            )
                    )
                ) {
                    $lowestPriceCarrierRange = $carrierRange;
                }
            } else {

                $lowestPriceCarrierRange = $carrierRange;
            }
        }

        return $lowestPriceCarrierRange;
    }

    /**
     * Get the CarrierRange with the highest price
     *
     * @param CarrierRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierRangeInterface Highest price CarrierRange
     */
    protected function getCarrierRangeWithHighestPrice(array $carrierRanges)
    {
        /**
         * @var CarrierRangeInterface $highestPriceCarrierRange
         */
        $highestPriceCarrierRange = null;

        foreach ($carrierRanges as $carrierRange) {

            $carrierRangePrice = $carrierRange->getPrice();

            if ($highestPriceCarrierRange instanceof CarrierRangeInterface) {

                if ($carrierRangePrice
                    ->isGreaterThan(
                        $this
                            ->currencyConverter
                            ->convertMoney(
                                $highestPriceCarrierRange->getPrice(),
                                $carrierRangePrice->getCurrency()
                            )
                    )
                ) {
                    $highestPriceCarrierRange = $carrierRange;
                }
            } else {

                $highestPriceCarrierRange = $carrierRange;
            }
        }

        return $highestPriceCarrierRange;
    }
}
