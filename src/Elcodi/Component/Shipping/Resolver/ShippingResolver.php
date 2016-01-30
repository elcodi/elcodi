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

namespace Elcodi\Component\Shipping\Resolver;

use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\Entity\ShippingMethod;

/**
 * Class ShippingResolver.
 */
class ShippingResolver
{
    /**
     * @var CurrencyConverter
     *
     * currencyConverter
     */
    private $currencyConverter;

    /**
     * Construct method.
     *
     * @param CurrencyConverter $currencyConverter Currency Converter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Given a set of shipping methods, return the one with the lowest price.
     *
     * @param ShippingMethod[] $shippingMethods Shipping methods
     *
     * @return ShippingMethod Lowest price shipping method
     */
    public function getCheapestShippingMethod(array $shippingMethods)
    {
        return array_reduce(
            $shippingMethods,
            function ($lowestPriceShippingMethod, ShippingMethod $shippingMethod) {

                $shippingMethodPrice = $shippingMethod->getPrice();
                if (
                    !($lowestPriceShippingMethod instanceof ShippingMethod) ||
                    $shippingMethodPrice
                        ->isLessThan(
                            $this
                                ->currencyConverter
                                ->convertMoney(
                                    $lowestPriceShippingMethod->getPrice(),
                                    $shippingMethodPrice->getCurrency()
                                )
                        )
                ) {
                    return $shippingMethod;
                }

                return $lowestPriceShippingMethod;
            },
            null
        );
    }
}
