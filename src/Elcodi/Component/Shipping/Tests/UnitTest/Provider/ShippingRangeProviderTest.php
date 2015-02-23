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
            ->method('getAmount')
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
        $carrierRange = $this->getShippingWeightRangeMock(
            $fromWeight,
            $toWeight
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByCart',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertEquals(
            $isSatisfied,
            $shippingRangeProvider->isShippingWeightRangeSatisfiedByCart(
                $this->cart,
                $carrierRange
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
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByCart',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByCart')
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
     * Test getCarrierRangeSatisfiedByCartOk
     */
    public function testGetCarrierRangeSatisfiedByCart()
    {
        $carrier = $this->getCarrierMock(50, 100, 10, 15);

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByCart',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertInstanceOf(
            'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface',
            $shippingRangeProvider->getCarrierRangeSatisfiedByCart(
                $this->cart,
                $carrier
            )
        );
    }

    /**
     * Test getCarrierRangeSatisfiedByCartFail
     */
    public function testGetCarrierRangeSatisfiedByCartFail()
    {
        $carrier = $this->getCarrierMock(10, 20, 50, 55);

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByCart',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $this->assertFalse(
            $shippingRangeProvider
                ->getCarrierRangeSatisfiedByCart(
                    $this->cart,
                    $carrier
                )
        );
    }

    /**
     * Test provideCarrierRangesSatisfiedWithOrder
     */
    public function testProvideCarrierRangesSatisfiedWithOrder()
    {
        $this
            ->carrierRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue(array(
                $this->getCarrierMock(100, 110, 40, 50),
                $this->getCarrierMock(120, 300, 500, 1000),
                $this->getCarrierMock(50, 101, 10, 10),
            )));

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByCart',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $shippingRangeProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByCart')
            ->will($this->returnValue(true));

        $carrierRanges = $shippingRangeProvider->provideCarrierRangesSatisfiedWithOrder($this->cart);

        $this->assertCount(2, $carrierRanges);

        foreach ($carrierRanges as $carrierRange) {
            $this->assertInstanceOf(
                'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface',
                $carrierRange
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

        $carrierRanges = array(
            $this->getShippingPriceRangeMock($fromPrice, $toPrice),
            $this->getShippingWeightRangeMock($fromWeight, $toWeight),
        );

        $carrier
            ->expects($this->any())
            ->method('getRanges')
            ->will($this->returnValue($carrierRanges));

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
        $carrierRange = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface');

        $carrierRange
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue(ElcodiShippingRangeTypes::TYPE_WEIGHT));

        $carrierRange
            ->expects($this->any())
            ->method('getFromWeight')
            ->will($this->returnValue($fromWeight));

        $carrierRange
            ->expects($this->any())
            ->method('getToWeight')
            ->will($this->returnValue($toWeight));

        return $carrierRange;
    }

    /**
     * Get isCarrierRangeZonesSatisfiedByCart with any Warehouse defined
     */
    public function testIsCarrierRangeZonesSatisfiedByCartNoWarehouse()
    {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $this->assertFalse(
            $shippingRangeProvider->isCarrierRangeZonesSatisfiedByCart(
                $this->cart,
                $carrierRange
            )
        );
    }

    /**
     * Get isCarrierRangeZonesSatisfiedByCart with any Warehouse address
     */
    public function testIsCarrierRangeZonesSatisfiedByCartWarehouseWithoutAddress()
    {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $warehouse = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface');

        $warehouse
            ->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue(null));

        $this->assertFalse(
            $shippingRangeProvider->isCarrierRangeZonesSatisfiedByCart(
                $this->cart,
                $carrierRange
            )
        );
    }

    /**
     * Get isCarrierRangeZonesSatisfiedByCart with any Warehouse address
     *
     * @dataProvider dataIsCarrierRangeZonesSatisfiedByCartWarehouseWithAddress
     */
    public function testIsCarrierRangeZonesSatisfiedByCartWarehouseWithAddress(
        $inZoneFrom,
        $inZoneTo,
        $isSatisfied
    ) {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $shippingRangeProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\ShippingRangeProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->zoneMatcher,
                $this->shippingRangeResolver,
            ))
            ->getMock();

        $warehouse = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface');
        $address = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');

        $warehouse
            ->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue($address));

        $this
            ->zoneMatcher
            ->expects($this->any())
            ->method('isAddressContainedInZone')
            ->will($this->onConsecutiveCalls($inZoneFrom, $inZoneTo));

        $carrierRange
            ->expects($this->any())
            ->method('getFromZone')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')));

        $carrierRange
            ->expects($this->any())
            ->method('getToZone')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')));

        $this
            ->cart
            ->expects($this->any())
            ->method('getDeliveryAddress')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface')));

        $this->assertEquals(
            $isSatisfied,
            $shippingRangeProvider->isCarrierRangeZonesSatisfiedByCart(
                $this->cart,
                $carrierRange
            )
        );
    }

    /**
     * data for testIsCarrierRangeZonesSatisfiedByCartWarehouseWithAddress
     */
    public function dataIsCarrierRangeZonesSatisfiedByCartWarehouseWithAddress()
    {
        return [
            [true, true, true],
            [true, false, false],
            [false, true, false],
            [false, false, false],
        ];
    }
}
