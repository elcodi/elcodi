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

namespace Elcodi\Component\Geo\Tests\UnitTest\Adapter;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Formatter\AddressFormatter;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class AddressManagerTest.
 */
class AddressFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AddressFormatter
     *
     * An address formatter
     */
    protected $addressFormatter;

    /**
     * @var LocationProviderAdapterInterface|\PHPUnit_Framework_MockObject_MockObject
     *
     * Location provider
     */
    protected $locationProvider;

    /**
     * Set ups the test to be executed.
     */
    public function setUp()
    {
        $this->locationProvider = $this->getMockBuilder(
            'Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressFormatter = new AddressFormatter(
            $this->locationProvider
        );
    }

    /**
     * Test the toArray method.
     */
    public function testFormatToArray()
    {
        $city = new LocationData(
            'city_id',
            'Estudis de TV3',
            '22',
            'city'
        );

        $country = new LocationData(
            'country_id',
            'Catalunya',
            '23',
            'country'
        );

        $address = $this->getAddress(
            '42',
            'My home',
            'Marc',
            'Robirosa',
            'C/ engonga',
            '43',
            '06580',
            '958652654',
            '647852365',
            'Aixo en el basquetbol es veu molt clar',
            'city_id'
        );

        $expectedFullAddress = 'C/ engonga 43, Estudis de TV3, Catalunya 06580';

        $expectedResponse = [
            'id' => '42',
            'name' => 'My home',
            'recipientName' => 'Marc',
            'recipientSurname' => 'Robirosa',
            'address' => 'C/ engonga',
            'addressMore' => '43',
            'postalCode' => '06580',
            'phone' => '958652654',
            'mobile' => '647852365',
            'comment' => 'Aixo en el basquetbol es veu molt clar',
            'city' => [
                'city' => 'Estudis de TV3',
                'country' => 'Catalunya',
            ],
            'fullAddress' => $expectedFullAddress,
        ];

        $this
            ->locationProvider
            ->expects($this->once())
            ->method('getHierarchy')
            ->with('city_id')
            ->will($this->returnValue([
                $country,
                $city,
            ]));

        $response = $this
            ->addressFormatter
            ->toArray($address);

        $this->assertSame(
            $expectedResponse,
            $response,
            'Unexpected method response'
        );
    }

    /**
     * Builds a address mock for test purposes.
     *
     * @param string $id               The identifier
     * @param string $name             The name
     * @param string $recipientName    The recipient name
     * @param string $recipientSurname The recipient surname
     * @param string $address          The address
     * @param string $addressMore      More address data
     * @param string $postalCode       The postal code
     * @param string $phone            The phone
     * @param string $mobile           The mobile phone
     * @param string $comment          The comment
     * @param string $cityId           The city id
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAddress(
        $id,
        $name,
        $recipientName,
        $recipientSurname,
        $address,
        $addressMore,
        $postalCode,
        $phone,
        $mobile,
        $comment,
        $cityId
    ) {
        $mock = $this->getMockBuilder(
            'Elcodi\Component\Geo\Entity\Address'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));

        $mock
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));

        $mock
            ->expects($this->any())
            ->method('getRecipientName')
            ->will($this->returnValue($recipientName));

        $mock
            ->expects($this->any())
            ->method('getRecipientSurname')
            ->will($this->returnValue($recipientSurname));

        $mock
            ->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue($address));

        $mock
            ->expects($this->any())
            ->method('getAddressMore')
            ->will($this->returnValue($addressMore));

        $mock
            ->expects($this->any())
            ->method('getPostalcode')
            ->will($this->returnValue($postalCode));

        $mock
            ->expects($this->any())
            ->method('getPhone')
            ->will($this->returnValue($phone));

        $mock
            ->expects($this->any())
            ->method('getMobile')
            ->will($this->returnValue($mobile));

        $mock
            ->expects($this->any())
            ->method('getComments')
            ->will($this->returnValue($comment));

        $mock
            ->expects($this->any())
            ->method('getCity')
            ->will($this->returnValue($cityId));

        return $mock;
    }
}
