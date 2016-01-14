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

namespace Elcodi\Component\Geo\Tests\UnitTest\Adapter\LocatorProvider;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Adapter\LocationProvider\LocationServiceProviderAdapter;
use Elcodi\Component\Geo\Repository\LocationRepository;
use Elcodi\Component\Geo\Transformer\LocationToLocationDataTransformer;

/**
 * Class LocationSeLoc.
 */
class LocationServiceProviderAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LocationRepository
     *
     * A location repository
     */
    protected $locationRepository;

    /**
     * @var LocationToLocationDataTransformer
     *
     * A location to locationData transformer
     */
    protected $locationToLocationDataTransformer;

    /**
     * @var LocationServiceProviderAdapter
     *
     * A location service provider
     */
    protected $locationServiceProviderAdapter;

    /**
     * Set ups the test to be executed.
     */
    public function setUp()
    {
        $this->locationRepository = $this->getMockBuilder(
            'Elcodi\Component\Geo\Repository\LocationRepository'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->locationToLocationDataTransformer = $this->getMockBuilder(
            'Elcodi\Component\Geo\Transformer\LocationToLocationDataTransformer'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->locationServiceProviderAdapter = new LocationServiceProviderAdapter(
            $this->locationRepository,
            $this->locationToLocationDataTransformer
        );
    }

    /**
     * Test the getAllRoots method.
     */
    public function testGetRootLocations()
    {
        $location = $this->getMockedLocation('id-root');
        $allRoots = [$location];
        $formattedRoot = 'formatted-root';
        $formattedAllRoots = [$formattedRoot];

        $this->locationRepository
            ->expects($this->once())
            ->method('findAllRoots')
            ->will($this->returnValue($allRoots));

        $this->locationToLocationDataTransformer
            ->expects($this->once())
            ->method('transform')
            ->with($location)
            ->will($this->returnValue($formattedRoot));

        $rootLocations = $this
            ->locationServiceProviderAdapter
            ->getRootLocations();

        $this->assertEquals(
            $formattedAllRoots,
            $rootLocations,
            'Method is not returning the expected value'
        );
    }

    /**
     * Test the getChildren method.
     */
    public function testGetChildren()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $childrenLocation = $this->getMockedLocation('id-children');
        $children = new ArrayCollection([$childrenLocation]);

        $locationId = 'id-test';
        $location = $this->getMockedLocation(
            $locationId,
            null,
            $children
        );

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue($location));

        $childrenResponse = $this
            ->locationServiceProviderAdapter
            ->getChildren($locationId);

        $this->assertEquals(
            [$childrenLocation],
            $childrenResponse,
            'Method is not returning the expected value'
        );
    }

    /**
     * Test the getChildren method when the given location is not found.
     */
    public function testGetChildrenNotFound()
    {
        $locationId = 'id-test';

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue(null));

        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException'
        );

        $this
            ->locationServiceProviderAdapter
            ->getChildren($locationId);
    }

    /**
     * Test the getParents.
     */
    public function testGetParents()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $parentLocation = $this->getMockedLocation('id-parent');
        $parents = new ArrayCollection([$parentLocation]);

        $locationId = 'id-test';
        $location = $this->getMockedLocation(
            $locationId,
            $parents
        );

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue($location));

        $childrenResponse = $this
            ->locationServiceProviderAdapter
            ->getParents($locationId);

        $this->assertEquals(
            [$parentLocation],
            $childrenResponse,
            'Method is not returning the expected value'
        );
    }

    /**
     * Test the getParents method when the given location is not found.
     */
    public function testGetParentsNotFound()
    {
        $locationId = 'id-test';

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue(null));

        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException'
        );

        $this
            ->locationServiceProviderAdapter
            ->getParents($locationId);
    }

    /**
     * Test get location.
     */
    public function testGetLocation()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $locationId = 'id-test';
        $location = $this->getMockedLocation($locationId);

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue($location));

        $locationResponse = $this
            ->locationServiceProviderAdapter
            ->getLocation($locationId);

        $this->assertEquals(
            $location,
            $locationResponse,
            'Method is not returning the expected value'
        );
    }

    /**
     * Test get location when the location is not found.
     */
    public function testGetLocationNotFound()
    {
        $locationId = 'id-test';

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue(null));

        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException'
        );

        $this
            ->locationServiceProviderAdapter
            ->getLocation($locationId);
    }

    /**
     * Test get hierarchy.
     */
    public function testGetHierarchy()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $locationId = 'id-test';
        $location = $this->getMockedLocation($locationId);
        $locationParentOne = $this->getMockedLocation('id-parent-one');
        $locationParentTwo = $this->getMockedLocation('id-parent-two');
        $parents = [$locationParentOne, $locationParentTwo];
        $location
            ->expects($this->once())
            ->method('getAllParents')
            ->will($this->returnValue($parents));

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue($location));

        $response = $this
            ->locationServiceProviderAdapter
            ->getHierarchy($locationId);

        $expectedResponse = [
            $location,
            $locationParentOne,
            $locationParentTwo,
        ];

        $this->assertEquals(
            $response,
            $expectedResponse,
            'Unexpected method response'
        );
    }

    /**
     * Test get hierarchy when the location is not found.
     */
    public function testGetHierarchyNotFound()
    {
        $locationId = 'id-test';

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue(null));

        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException'
        );

        $this
            ->locationServiceProviderAdapter
            ->getHierarchy($locationId);
    }

    /**
     * Test in method for one place to search and id is found.
     */
    public function testInOnePlaceToSearchFound()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $searchedId = 'id-parent-one';

        $searchInLocationId = 'id-test';
        $searchInLocation = $this->getMockedLocation($searchInLocationId);
        $searchInParentOne = $this->getMockedLocation($searchedId);
        $searchInParentTwo = $this->getMockedLocation('id-parent-two');
        $parents = [$searchInParentOne, $searchInParentTwo];
        $searchInLocation
            ->expects($this->once())
            ->method('getAllParents')
            ->will($this->returnValue($parents));

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $searchedId])
            ->will($this->returnValue($searchInLocation));

        $response = $this
            ->locationServiceProviderAdapter
            ->in($searchedId, [$searchInLocationId]);

        $this->assertTrue(
            $response,
            'The searched id should be found'
        );
    }

    /**
     * Test in method for one place to search and id is not found.
     */
    public function testInOnePlaceToSearchNotFound()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $searchInLocationId = 'id-test';
        $searchInLocation = $this->getMockedLocation($searchInLocationId);
        $searchInParentOne = $this->getMockedLocation('id-parent-one');
        $searchInParentTwo = $this->getMockedLocation('id-parent-two');
        $parents = [$searchInParentOne, $searchInParentTwo];
        $searchInLocation
            ->expects($this->once())
            ->method('getAllParents')
            ->will($this->returnValue($parents));

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $searchInLocationId])
            ->will($this->returnValue($searchInLocation));

        $response = $this
            ->locationServiceProviderAdapter
            ->in('id-test', ['id-search-in']);

        $this->assertFalse(
            $response,
            'The searched id should not be found'
        );
    }

    /**
     * Test in method on two places to search and id is found.
     */
    public function testInTwoPlacesSearchFound()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $searchedId = 'id-parent-one';

        $searchInLocationId = 'id-search-here';
        $searchInAnotherLocationId = 'id-search-here-too';
        $searchInAnotherLocation = $this->getMockedLocation(
            $searchInAnotherLocationId
        );
        $searchInParentOne = $this->getMockedLocation($searchedId);
        $searchInParentTwo = $this->getMockedLocation('id-parent-two');
        $parents = [$searchInParentOne, $searchInParentTwo];
        $searchInAnotherLocation
            ->expects($this->once())
            ->method('getAllParents')
            ->will($this->returnValue($parents));

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $searchedId])
            ->will($this->returnValue($searchInAnotherLocation));

        $response = $this
            ->locationServiceProviderAdapter
            ->in(
                $searchedId,
                [
                    $searchInLocationId,
                    $searchInAnotherLocationId,
                ]
            );

        $this->assertTrue(
            $response,
            'The searched id should be found'
        );
    }

    /**
     * Test in method on two places to search and id is not found.
     */
    public function testInTwoPlacesSearchNotFound()
    {
        $this->locationToLocationDataTransformer
            ->expects($this->atLeastOnce())
            ->method('transform')
            ->will($this->returnArgument(0));

        $searchInLocationId = 'id-test';
        $searchInLocation = $this->getMockedLocation($searchInLocationId);
        $searchInParentOne = $this->getMockedLocation('id-parent-one');
        $searchInParentTwo = $this->getMockedLocation('id-parent-two');
        $parents = [$searchInParentOne, $searchInParentTwo];
        $searchInLocation
            ->expects($this->once())
            ->method('getAllParents')
            ->will($this->returnValue($parents));

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $searchInLocationId])
            ->will($this->returnValue($searchInLocation));

        $response = $this
            ->locationServiceProviderAdapter
            ->in(
                'id-test',
                [
                    'id-search-in',
                    'id-search-also-here',
                ]
            );

        $this->assertFalse(
            $response,
            'The searched id should not be found'
        );
    }

    /**
     * Test the in method when the received location is not found.
     */
    public function testInLocationNotFound()
    {
        $locationId = 'id-test';
        $locationSearchIds = ['id-search1', 'id-search2'];

        $this->locationRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $locationId])
            ->will($this->returnValue(null));

        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException'
        );

        $this
            ->locationServiceProviderAdapter
            ->in(
                $locationId,
                $locationSearchIds
            );
    }

    /**
     * Gets a mocked location with the received parents and children.
     *
     * @param string          $id       The location id
     * @param ArrayCollection $parents  The location parents
     * @param ArrayCollection $children The location children
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockedLocation(
        $id,
        ArrayCollection $parents = null,
        ArrayCollection $children = null
    ) {
        $mock = $this->getMock(
            'Elcodi\Component\Geo\Entity\Location'
        );
        $mock
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));

        if (!is_null($parents)) {
            $mock
                ->expects($this->any())
                ->method('getParents')
                ->will($this->returnValue($parents));
        }

        if (!is_null($children)) {
            $mock
                ->expects($this->any())
                ->method('getChildren')
                ->will($this->returnValue($children));
        }

        return $mock;
    }
}
