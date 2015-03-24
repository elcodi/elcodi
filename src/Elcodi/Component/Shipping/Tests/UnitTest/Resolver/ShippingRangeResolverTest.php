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

namespace Elcodi\Component\Shipping\Tests\UnitTest\Resolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingResolverTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Resolver\ShippingRangeResolver;

/**
 * Class ShippingRangeResolverTest
 */
class ShippingRangeResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    private $currency;

    /**
     * @var ShippingRangeInterface[]
     *
     * ShippingRange collection
     */
    private $shippingRanges;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->currencyConverter = $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false);

        $this
            ->currencyConverter
            ->expects($this->any())
            ->method('convertMoney')
            ->will($this->returnArgument(0));

        $this->currency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $this->currency
            ->expects($this->any())
            ->method('getSymbol')
            ->will($this->returnValue('$'));

        $this->currency
            ->expects($this->any())
            ->method('getIso')
            ->will($this->returnValue('USD'));

        $cheapShippingRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $cheapShippingRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(10, $this->currency)));

        $mediumShippingRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $mediumShippingRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(20, $this->currency)));

        $expensiveShippingRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $expensiveShippingRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(30, $this->currency)));

        $this->shippingRanges = [
            $cheapShippingRange,
            $mediumShippingRange,
            $expensiveShippingRange,
        ];
    }

    /**
     * Test all ShippingRanges with same currency
     */
    public function testResolveAllShippingRangesSameCurrency()
    {
        $shippingRangeResolver = new ShippingRangeResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_ALL
        );

        $ranges = $shippingRangeResolver->resolveShippingRanges($this->shippingRanges);
        $this->assertSame(
            $this->shippingRanges,
            $ranges
        );
    }

    /**
     * Test lowest ShippingRange with same currency
     */
    public function testResolveLowestShippingRangesSameCurrency()
    {
        $shippingRangeResolver = new ShippingRangeResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_LOWEST
        );

        $ranges = $shippingRangeResolver->resolveShippingRanges($this->shippingRanges);
        $this->assertCount(1, $ranges);
        $range = reset($ranges);
        $this->assertSame(
            10,
            $range->getPrice()->getAmount()
        );
    }

    /**
     * Test highest ShippingRange with same currency
     */
    public function testResolveHighestShippingRangesSameCurrency()
    {
        $shippingRangeResolver = new ShippingRangeResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::SHIPPING_RANGE_RESOLVER_HIGHEST
        );

        $ranges = $shippingRangeResolver->resolveShippingRanges($this->shippingRanges);
        $this->assertCount(1, $ranges);
        $range = reset($ranges);
        $this->assertSame(
            30,
            $range->getPrice()->getAmount()
        );
    }
}
