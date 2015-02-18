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

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingWeightRangeInterface;
use Elcodi\Component\Shipping\Repository\CarrierRepository;
use Elcodi\Component\Shipping\Repository\WarehouseRepository;
use Elcodi\Component\Zone\Services\ZoneMatcher;

/**
 * Class CarrierProviderTest
 */
class CarrierProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

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
     * @var WarehouseRepository
     *
     * Warehouse repository
     */
    private $warehouseRepository;

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
        $this->order = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface');
        $this->carrierRepository = $this->getMock('Elcodi\Component\Shipping\Repository\CarrierRepository', [], [], '', false);
        $this->currencyConverter = $this->getMock('Elcodi\Component\Currency\Services\CurrencyConverter', [], [], '', false);
        $this->warehouseRepository = $this->getMock('Elcodi\Component\Shipping\Repository\WarehouseRepository', [], [], '', false);
        $this->zoneMatcher = $this->getMock('Elcodi\Component\Zone\Services\ZoneMatcher', [], [], '', false);

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
            ->order
            ->expects($this->any())
            ->method('getWeight')
            ->will($this->returnValue(10));

        $this
            ->order
            ->expects($this->any())
            ->method('getAmount')
            ->will($this->returnValue($amount));
    }

    /**
     * Tests isShippingWeightRangeSatisfiedByOrder
     *
     * @dataProvider dataIsShippingWeightRangeSatisfiedByOrderOk
     */
    public function testIsShippingWeightRangeSatisfiedByOrder(
        $fromWeight,
        $toWeight,
        $isSatisfied
    ) {
        $carrierRange = $this->getShippingWeightRangeMock(
            $fromWeight,
            $toWeight
        );

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByOrder',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $carrierProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByOrder')
            ->will($this->returnValue(true));

        $this->assertEquals(
            $isSatisfied,
            $carrierProvider->isShippingWeightRangeSatisfiedByOrder(
                $this->order,
                $carrierRange
            )
        );
    }

    /**
     * Data for testIsShippingWeightRangeSatisfiedByOrder
     *
     * @return array
     */
    public function dataIsShippingWeightRangeSatisfiedByOrderOk()
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
     * Tests isShippingPriceRangeSatisfiedByOrder
     *
     * @dataProvider dataIsShippingPriceRangeSatisfiedByOrder
     */
    public function testIsShippingPriceRangeSatisfiedByOrder(
        $fromPrice,
        $toPrice,
        $isSatisfied
    ) {
        $priceRange = $this->getShippingPriceRangeMock(
            $fromPrice,
            $toPrice
        );

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByOrder',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $carrierProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByOrder')
            ->will($this->returnValue(true));

        $this->assertEquals(
            $isSatisfied,
            $carrierProvider->isShippingPriceRangeSatisfiedByOrder(
                $this->order,
                $priceRange
            )
        );
    }

    /**
     * Data for testIsShippingPriceRangeSatisfiedByOrder
     *
     * @return array
     */
    public function dataIsShippingPriceRangeSatisfiedByOrder()
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
     * Test getCarrierRangeSatisfiedByOrderOk
     */
    public function testGetCarrierRangeSatisfiedByOrder()
    {
        $carrier = $this->getCarrierMock(50, 100, 10, 15);

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByOrder',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $carrierProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByOrder')
            ->will($this->returnValue(true));

        $this->assertInstanceOf(
            'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface',
            $carrierProvider->getCarrierRangeSatisfiedByOrder(
                $this->order,
                $carrier
            )
        );
    }

    /**
     * Test getCarrierRangeSatisfiedByOrderFail
     */
    public function testGetCarrierRangeSatisfiedByOrderFail()
    {
        $carrier = $this->getCarrierMock(10, 20, 50, 55);

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByOrder',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $carrierProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByOrder')
            ->will($this->returnValue(true));

        $this->assertFalse(
            $carrierProvider
                ->getCarrierRangeSatisfiedByOrder(
                    $this->order,
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

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(array(
                'isCarrierRangeZonesSatisfiedByOrder',
            ))
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $carrierProvider
            ->expects($this->any())
            ->method('isCarrierRangeZonesSatisfiedByOrder')
            ->will($this->returnValue(true));

        $carrierRanges = $carrierProvider->provideCarrierRangesSatisfiedWithOrder($this->order);

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
     * Get isCarrierRangeZonesSatisfiedByOrder with any Warehouse defined
     */
    public function testIsCarrierRangeZonesSatisfiedByOrderNoWarehouse()
    {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $this
            ->warehouseRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $this->assertFalse(
            $carrierProvider->isCarrierRangeZonesSatisfiedByOrder(
                $this->order,
                $carrierRange
            )
        );
    }

    /**
     * Get isCarrierRangeZonesSatisfiedByOrder with any Warehouse address
     */
    public function testIsCarrierRangeZonesSatisfiedByOrderWarehouseWithoutAddress()
    {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
            ))
            ->getMock();

        $warehouse = $this->getMock('Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface');

        $warehouse
            ->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue(null));

        $this
            ->warehouseRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($warehouse));

        $this->assertFalse(
            $carrierProvider->isCarrierRangeZonesSatisfiedByOrder(
                $this->order,
                $carrierRange
            )
        );
    }

    /**
     * Get isCarrierRangeZonesSatisfiedByOrder with any Warehouse address
     *
     * @dataProvider dataIsCarrierRangeZonesSatisfiedByOrderWarehouseWithAddress
     */
    public function testIsCarrierRangeZonesSatisfiedByOrderWarehouseWithAddress(
        $inZoneFrom,
        $inZoneTo,
        $isSatisfied
    ) {
        $carrierRange = $this->getShippingWeightRangeMock(
            10,
            20
        );

        $carrierProvider = $this
            ->getMockBuilder('Elcodi\Component\Shipping\Provider\CarrierProvider')
            ->setMethods(null)
            ->setConstructorArgs(array(
                $this->carrierRepository,
                $this->currencyConverter,
                $this->warehouseRepository,
                $this->zoneMatcher,
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

        $this
            ->warehouseRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($warehouse));

        $carrierRange
            ->expects($this->any())
            ->method('getFromZone')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')));

        $carrierRange
            ->expects($this->any())
            ->method('getToZone')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface')));

        $this
            ->order
            ->expects($this->any())
            ->method('getDeliveryAddress')
            ->will($this->returnValue($this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface')));

        $this->assertEquals(
            $isSatisfied,
            $carrierProvider->isCarrierRangeZonesSatisfiedByOrder(
                $this->order,
                $carrierRange
            )
        );
    }

    /**
     * data for testIsCarrierRangeZonesSatisfiedByOrderWarehouseWithAddress
     */
    public function dataIsCarrierRangeZonesSatisfiedByOrderWarehouseWithAddress()
    {
        return [
            [true, true, true],
            [true, false, false],
            [false, true, false],
            [false, false, false],
        ];
    }
}
