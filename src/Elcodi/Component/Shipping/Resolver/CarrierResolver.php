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

namespace Elcodi\Component\Shipping\Resolver;

use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingResolverTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierBaseRangeInterface;

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
     * @param CarrierBaseRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierBaseRangeInterface[] Valid carrier ranges
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
     * @param CarrierBaseRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierBaseRangeInterface Lowest price CarrierRange
     */
    protected function getCarrierRangeWithLowestPrice(array $carrierRanges)
    {
        /**
         * @var CarrierBaseRangeInterface $lowestPriceCarrierRange
         */
        $lowestPriceCarrierRange = null;

        foreach ($carrierRanges as $carrierRange) {
            $carrierRangePrice = $carrierRange->getPrice();

            if ($lowestPriceCarrierRange instanceof CarrierBaseRangeInterface) {
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
     * @param CarrierBaseRangeInterface[] $carrierRanges Carrier Ranges set
     *
     * @return CarrierBaseRangeInterface Highest price CarrierRange
     */
    protected function getCarrierRangeWithHighestPrice(array $carrierRanges)
    {
        /**
         * @var CarrierBaseRangeInterface $highestPriceCarrierRange
         */
        $highestPriceCarrierRange = null;

        foreach ($carrierRanges as $carrierRange) {
            $carrierRangePrice = $carrierRange->getPrice();

            if ($highestPriceCarrierRange instanceof CarrierBaseRangeInterface) {
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
