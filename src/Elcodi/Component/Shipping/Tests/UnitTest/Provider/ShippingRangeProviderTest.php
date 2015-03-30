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

namespace Elcodi\Component\Shipping\Tests\UnitTest\Provider;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingWeightRangeInterface;
use Elcodi\Component\Shipping\Repository\CarrierRepository;
use Elcodi\Component\Shipping\Resolver\ShippingRangeResolver;
use Elcodi\Component\Zone\Services\ZoneMatcher;

/**
 * Class ShippingRangeProviderTest
 */
class ShippingRangeProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    private $cart;

    /**
     * @var CarrierRepository
     *
     * Carrier repository
     */
    private $carrierRepository;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var ShippingRangeResolver
     *
     * ShippingRange Resolver
     */
    private $shippingRangeResolver;

    /**
     * @var ZoneMatcher
     *
     * ZoneMatcher
     */
    protected $zoneMatcher;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    private $currency;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->cart = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $this->carrierRepository = $this->getMock('Elcodi\Component\Shipping\Repository\CarrierRepository', [], [], '', false);
        $this->currencyConverter = $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false);
        $this->zoneMatcher = $this->getMock('Elcodi\Component\Zone\Services\ZoneMatcher', [], [], '', false);
        $this->shippingRangeResolver = $this->getMock('Elcodi\Component\Shipping\Resolver\ShippingRangeResolver', [], [], '', false);

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

        $amount = Money::create(100, $this->currency);

        $this
            ->cart
            ->expects($this->any())
            ->method('getWeight')
            ->will($this->returnValue(10));

        $this
            ->cart
            ->expects($this->any())
            ->method('getProductAmount')
            ->will($this->returnValue($amount));
    }

    /**
     * Tests isShippingWeightRangeSatisfiedByCart
     *
     * @dataProvider dataIsShippingWeightRangeSatisfiedByCartOk
     */
    public function testIsShippingWeightRangeSatisfiedByCart(
        $fromWeight,
        $toWeight,
        $isSatisfied
    ) {
        $shippingRange = $this->getShippingWeightRangeMock(
            $fromWeight,
            $toWeight
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods([
                'isShippingRangeZonesSatisfiedByCart',
            ])
            ->setConstructorArgs([
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ])
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isShippingRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertEquals(
            $isSatisfied,
            $shippingRangeProvider->isShippingWeightRangeSatisfiedByCart(
                $this->cart,
                $shippingRange
            )
        );
    }

    /**
     * Data for testIsShippingWeightRangeSatisfiedByCart
     *
     * @return array
     */
    public function dataIsShippingWeightRangeSatisfiedByCartOk()
    {
        return [
            [5, 15, true],
            [5, 10, false],
            [10, 15, true],
            [10, 10, false],
            [5, 9, false],
            [11, 15, false],
            [10, null, false],
            [10, true, false],
            [10, false, false],
            [null, null, false],
            [true, true, false],
        ];
    }

    /**
     * Tests isShippingPriceRangeSatisfiedByCart
     *
     * @dataProvider dataIsShippingPriceRangeSatisfiedByCart
     */
    public function testIsShippingPriceRangeSatisfiedByCart(
        $fromPrice,
        $toPrice,
        $isSatisfied
    ) {
        $priceRange = $this->getShippingPriceRangeMock(
            $fromPrice,
            $toPrice
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods([
                'isShippingRangeZonesSatisfiedByCart',
            ])
            ->setConstructorArgs([
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ])
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isShippingRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertEquals(
            $isSatisfied,
            $shippingRangeProvider->isShippingPriceRangeSatisfiedByCart(
                $this->cart,
                $priceRange
            )
        );
    }

    /**
     * Data for testIsShippingPriceRangeSatisfiedByCart
     *
     * @return array
     */
    public function dataIsShippingPriceRangeSatisfiedByCart()
    {
        return [
            [50, 150, true],
            [50, 100, false],
            [100, 150, true],
            [100, 100, false],
            [50, 90, false],
            [110, 150, false],
        ];
    }

    /**
     * Test getShippingRangeSatisfiedByCartOk
     */
    public function testGetShippingRangeSatisfiedByCart()
    {
        $carrier = $this->getCarrierMock(50, 100, 10, 15);

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods([
                'isShippingRangeZonesSatisfiedByCart',
            ])
            ->setConstructorArgs([
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ])
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isShippingRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertInstanceOf(
            'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface',
            $shippingRangeProvider->getShippingRangeSatisfiedByCart(
                $this->cart,
                $carrier
            )
        );
    }

    /**
     * Test getShippingRangeSatisfiedByCartFail
     */
    public function testGetShippingRangeSatisfiedByCartFail()
    {
        $carrier = $this->getCarrierMock(10, 20, 50, 55);

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods([
                'isShippingRangeZonesSatisfiedByCart',
            ])
            ->setConstructorArgs([
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ])
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isShippingRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertFalse(
            $shippingRangeProvider
                ->getShippingRangeSatisfiedByCart(
                    $this->cart,
                    $carrier
                )
        );
    }

    /**
     * Test getAllShippingRangesSatisfiedWithCart
     */
    public function testAllGetShippingRangesSatisfiedWithCart()
    {
        $this
            ->carrierRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue([
                $this->getCarrierMock(100, 110, 40, 50),
                $this->getCarrierMock(120, 300, 500, 1000),
                $this->getCarrierMock(50, 101, 10, 10),
            ]));

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods([
                'isShippingRangeZonesSatisfiedByCart',
            ])
            ->setConstructorArgs([
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ])
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isShippingRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $shippingRanges = $shippingRangeProvider->getAllShippingRangesSatisfiedWithCart($this->cart);

        $this->assertCount(1, $shippingRanges);

        foreach ($shippingRanges as $shippingRange) {
            $this->assertInstanceOf(
                'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface',
                $shippingRange
            );
        }
    }

    /**
     * Get Carrier mock
     *
     * @param string $fromPrice  From price
     * @param string $toPrice    To price
     * @param string $fromWeight From weight
     * @param string $toWeight   To weight
     *
     * @return CarrierInterface
     */
    private function getCarrierMock(
        $fromPrice,
        $toPrice,
        $fromWeight,
        $toWeight
    ) {
        $carrier = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface');

        $shippingRanges = [
            $this->getShippingPriceRangeMock($fromPrice, $toPrice),
            $this->getShippingWeightRangeMock($fromWeight, $toWeight),
        ];

        $carrier
            ->expects($this->any())
            ->method('getRanges')
            ->will($this->returnValue($shippingRanges));

        return $carrier;
    }

    /**
     * Get ShippingPriceRange mock
     *
     * @param string $fromPrice From price
     * @param string $toPrice   To price
     *
     * @return ShippingWeightRangeInterface
     */
    private function getShippingPriceRangeMock(
        $fromPrice,
        $toPrice
    ) {
        $priceRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $priceRange
            ->expects($this->any())
            ->method('getFromPrice')
            ->will($this->returnValue(
                Money::create($fromPrice, $this->currency)
            ));

        $priceRange
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue(ElcodiShippingRangeTypes::TYPE_PRICE));

        $priceRange
            ->expects($this->any())
            ->method('getToPrice')
            ->will($this->returnValue(
                Money::create($toPrice, $this->currency)
            ));

        return $priceRange;
    }

    /**
     * Get ShippingWeightRange mock
     *
     * @param string $fromWeight From weight
     * @param string $toWeight   To weight
     *
     * @return ShippingWeightRangeInterface
     */
    private function getShippingWeightRangeMock(
        $fromWeight,
        $toWeight
    ) {
        $shippingRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $shippingRange
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue(ElcodiShippingRangeTypes::TYPE_WEIGHT));

        $shippingRange
            ->expects($this->any())
            ->method('getFromWeight')
            ->will($this->returnValue($fromWeight));

        $shippingRange
            ->expects($this->any())
            ->method('getToWeight')
            ->will($this->returnValue($toWeight));

        return $shippingRange;
    }
}
