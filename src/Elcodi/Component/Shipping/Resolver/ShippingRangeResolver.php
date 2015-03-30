<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;

/**
 * Class ShippingRangeResolver
 */
class ShippingRangeResolver
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
    protected $shippingRangeResolverStrategy;

    /**
     * Construct method
     *
     * @param CurrencyConverter $currencyConverter             Currency Converter
     * @param integer           $shippingRangeResolverStrategy Carrier Resolver Type
     */
    public function __construct(
        CurrencyConverter $currencyConverter,
        $shippingRangeResolverStrategy
    ) {
        $this->currencyConverter = $currencyConverter;
        $this->shippingRangeResolverStrategy = $shippingRangeResolverStrategy;
    }

    /**
     * Resolve valid carrier given a set of them
     *
     * @param ShippingRangeInterface[] $shippingRanges Carrier Ranges set
     *
     * @return ShippingRangeInterface[] Valid carrier ranges
     */
    public function resolveShippingRanges(array $shippingRanges)
    {
        $validShippingRanges = [];

        switch ($this->shippingRangeResolverStrategy) {

            case ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_ALL:
                $validShippingRanges = $shippingRanges;
                break;

            case ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_LOWEST:
                $validShippingRanges = [$this->getShippingRangeWithLowestPrice($shippingRanges)];
                break;

            case ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_HIGHEST:
                $validShippingRanges = [$this->getShippingRangeWithHighestPrice($shippingRanges)];
                break;
        }

        return $validShippingRanges;
    }

    /**
     * Get the ShippingRange with the lowest price
     *
     * @param ShippingRangeInterface[] $shippingRanges Carrier Ranges set
     *
     * @return ShippingRangeInterface Lowest price ShippingRange
     */
    public function getShippingRangeWithLowestPrice(array $shippingRanges)
    {
        /**
         * @var ShippingRangeInterface $lowestPriceShippingRange
         */
        $lowestPriceShippingRange = null;

        foreach ($shippingRanges as $shippingRange) {
            $shippingRangePrice = $shippingRange->getPrice();

            if ($lowestPriceShippingRange instanceof ShippingRangeInterface) {
                if ($shippingRangePrice
                    ->isLessThan(
                        $this
                            ->currencyConverter
                            ->convertMoney(
                                $lowestPriceShippingRange->getPrice(),
                                $shippingRangePrice->getCurrency()
                            )
                    )
                ) {
                    $lowestPriceShippingRange = $shippingRange;
                }
            } else {
                $lowestPriceShippingRange = $shippingRange;
            }
        }

        return $lowestPriceShippingRange;
    }

    /**
     * Get the ShippingRange with the highest price
     *
     * @param ShippingRangeInterface[] $shippingRanges Carrier Ranges set
     *
     * @return ShippingRangeInterface Highest price ShippingRange
     */
    public function getShippingRangeWithHighestPrice(array $shippingRanges)
    {
        /**
         * @var ShippingRangeInterface $highestPriceShippingRange
         */
        $highestPriceShippingRange = null;

        foreach ($shippingRanges as $shippingRange) {
            $shippingRangePrice = $shippingRange->getPrice();

            if ($highestPriceShippingRange instanceof ShippingRangeInterface) {
                if ($shippingRangePrice
                    ->isGreaterThan(
                        $this
                            ->currencyConverter
                            ->convertMoney(
                                $highestPriceShippingRange->getPrice(),
                                $shippingRangePrice->getCurrency()
                            )
                    )
                ) {
                    $highestPriceShippingRange = $shippingRange;
                }
            } else {
                $highestPriceShippingRange = $shippingRange;
            }
        }

        return $highestPriceShippingRange;
    }
}
