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
 */

namespace Elcodi\Component\Shipping\Tests\UnitTest\Resolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingResolverTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierBaseRangeInterface;
use Elcodi\Component\Shipping\Resolver\CarrierResolver;

/**
 * Class CarrierResolverTest
 */
class CarrierResolverTest extends PHPUnit_Framework_TestCase
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
     * @var CarrierBaseRangeInterface[]
     *
     * CarrierRange collection
     */
    private $carrierRanges;

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

        $cheapCarrierRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\CarrierBaseRangeInterface');

        $cheapCarrierRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(10, $this->currency)));

        $mediumCarrierRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\CarrierBaseRangeInterface');

        $mediumCarrierRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(20, $this->currency)));

        $expensiveCarrierRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\CarrierBaseRangeInterface');

        $expensiveCarrierRange
            ->expects($this->any())
            ->method('getPrice')
            ->will($this->returnValue(Money::create(30, $this->currency)));

        $this->carrierRanges = array(
            $cheapCarrierRange,
            $mediumCarrierRange,
            $expensiveCarrierRange
        );
    }

    /**
     * Test all CarrierRanges with same currency
     */
    public function testResolveAllCarrierRangesSameCurrency()
    {
        $carrierResolver = new CarrierResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::CARRIER_RESOLVER_ALL
        );

        $ranges = $carrierResolver->resolveCarrierRanges($this->carrierRanges);
        $this->assertSame(
            $this->carrierRanges,
            $ranges
        );
    }

    /**
     * Test lowest CarrierRange with same currency
     */
    public function testResolveLowestCarrierRangesSameCurrency()
    {
        $carrierResolver = new CarrierResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::CARRIER_RESOLVER_LOWEST
        );

        $ranges = $carrierResolver->resolveCarrierRanges($this->carrierRanges);
        $this->assertCount(1, $ranges);
        $range = reset($ranges);
        $this->assertSame(
            10,
            $range->getPrice()->getAmount()
        );
    }

    /**
     * Test highest CarrierRange with same currency
     */
    public function testResolveHighestCarrierRangesSameCurrency()
    {
        $carrierResolver = new CarrierResolver(
            $this->currencyConverter,
            ElcodiShippingResolverTypes::CARRIER_RESOLVER_HIGHEST
        );

        $ranges = $carrierResolver->resolveCarrierRanges($this->carrierRanges);
        $this->assertCount(1, $ranges);
        $range = reset($ranges);
        $this->assertSame(
            30,
            $range->getPrice()->getAmount()
        );
    }
}
