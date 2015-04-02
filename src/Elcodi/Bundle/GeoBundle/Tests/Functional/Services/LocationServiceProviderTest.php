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

namespace Elcodi\Bundle\GeoBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationServiceProviderTest
 * @group now
 */
class LocationServiceProviderTest extends WebTestCase
{
    /**
     * @var LocationProviderInterface
     *
     * LocationProvider class
     */
    protected $locationProvider;

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi.location_provider.service'];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiGeoBundle',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var LocationProviderInterface $locationProvider
         */
        $this->locationProvider = $this->get('elcodi.location_provider.service');
    }

    /**
     * Test that we are returning the root locations
     */
    public function testGetRootLocations()
    {
        $rootLocations = $this
            ->locationProvider
            ->getRootLocations();

        $this->assertCount(
            1,
            $rootLocations,
            'We only expect one zone to be root'
        );

        /**
         * @var LocationData $location
         */
        $location = reset($rootLocations);
        $this->assertInstanceOf(
            'Elcodi\Component\Geo\ValueObject\LocationData',
            $location,
            'The response should be a LocationData'
        );

        $this->assertEquals(
            'Spain',
            $location->getName(),
            'Spain is the only root location'
        );
    }

    /**
     * Test get children
     */
    public function testGetChildren()
    {
        $locations = $this
            ->locationProvider
            ->getChildren('ES');

        $this->assertCount(
            1,
            $locations,
            'We only expect one location to be returned'
        );

        /**
         * @var LocationData $children
         */
        $children = reset($locations);

        $this->assertInstanceOf(
            'Elcodi\Component\Geo\ValueObject\LocationData',
            $children,
            'The response should be a LocationData'
        );

        $this->assertEquals(
            'Catalunya',
            $children->getName(),
            'We expect only Catalunya as children of Spain'
        );
    }

    /**
     * Test get children with a non-existent entity
     */
    public function testGetChildrenLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );

        $this
            ->locationProvider
            ->getChildren('UNEXISTENT');
    }

    /**
     * Test get children with a location without children
     */
    public function testGetChildrenNotFound()
    {
        $locations = $this
            ->locationProvider
            ->getChildren('ES_CA_VO_SantCeloni_08470');

        $this->assertCount(
            0,
            $locations,
            'We don\'t expect any location to be returned'
        );
    }

    /**
     * Test get parents
     */
    public function testGetParents()
    {
        $locations = $this
            ->locationProvider
            ->getParents('ES_CA');

        $this->assertCount(
            1,
            $locations,
            'We only expect one location to be returned'
        );

        /**
         * @var LocationData $children
         */
        $children = reset($locations);

        $this->assertInstanceOf(
            'Elcodi\Component\Geo\ValueObject\LocationData',
            $children,
            'The response should be a LocationData'
        );

        $this->assertEquals(
            'Spain',
            $children->getName(),
            'We expect only Spain as parent of Catalunya'
        );
    }

    /**
     * Test get parents with a non-existent location
     */
    public function testGetParentsLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );

        $this
            ->locationProvider
            ->getParents('UNEXISTENT');
    }

    /**
     * Test get parents with a root location
     */
    public function testGetParentsNotFound()
    {
        $locations = $this
            ->locationProvider
            ->getParents('ES');

        $this->assertCount(
            0,
            $locations,
            'We don\'t expect any location to be returned'
        );
    }

    /**
     * Test get location
     */
    public function testGetLocation()
    {
        $location = $this
            ->locationProvider
            ->getLocation('ES_CA');

        $this->assertInstanceOf(
            'Elcodi\Component\Geo\ValueObject\LocationData',
            $location,
            'The response should be a LocationData'
        );

        $this->assertEquals(
            'ES_CA',
            $location->getId(),
            'Unexpected id for the received location'
        );

        $this->assertEquals(
            'Catalunya',
            $location->getName(),
            'Unexpected name for the received location'
        );

        $this->assertEquals(
            'CA',
            $location->getCode(),
            'Unexpected code for the received location'
        );

        $this->assertEquals(
            'provincia',
            $location->getType(),
            'Unexpected type for the received location'
        );
    }

    /**
     * Test get location not found
     */
    public function testGetLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );

        $this
            ->locationProvider
            ->getLocation('UNEXISTENT');
    }

    /**
     * Test get hierarchy
     */
    public function testGetHierarchy()
    {
        $hierarchy = $this
            ->locationProvider
            ->getHierarchy('ES_CA_VO_SantCeloni');

        $expectedHierarchyNames = [
            'Spain',
            'Catalunya',
            'Valles Oriental',
            'Sant Celoni',
        ];

        $this->assertCount(
            count($expectedHierarchyNames),
            $hierarchy,
            'The height of the received hierarchy tree is incorrect'
        );

        foreach ($hierarchy as $key => $hierarchyNode) {
            $this->assertInstanceOf(
                'Elcodi\Component\Geo\ValueObject\LocationData',
                $hierarchyNode,
                'Every node received should be a LocationData'
            );

            $this->assertEquals(
                $expectedHierarchyNames[$key],
                $hierarchyNode->getName(),
                'Unexpected name for one of the received nodes'
            );
        }
    }

    /**
     * Test get hierarchy for multiple paths
     */
    public function testGetHierarchyMultiplePaths()
    {
        $hierarchy = $this
            ->locationProvider
            ->getHierarchy('ES_CA_VO_SantCeloni_08470');

        $expectedHierarchyNames = [
            'Spain',
            'Catalunya',
            'Valles Oriental',
            'La Batlloria',
            'Sant Celoni',
            '08470',
        ];

        $this->assertCount(
            count($expectedHierarchyNames),
            $hierarchy,
            'The height of the received hierarchy tree is incorrect'
        );

        $hierarchyNames = [];
        foreach ($hierarchy as $key => $hierarchyNode) {
            $this->assertInstanceOf(
                'Elcodi\Component\Geo\ValueObject\LocationData',
                $hierarchyNode,
                'Every node received should be a LocationData'
            );

            $hierarchyNames[] = $hierarchyNode->getName();
        }

        $this->assertSame(
            sort($hierarchyNames),
            sort($expectedHierarchyNames),
            'Unexpected hierarchy returned'
        );
    }

    /**
     * Public function test get hierarchy not found.
     */
    public function testGetHierarchyNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );

        $this
            ->locationProvider
            ->getHierarchy('UNEXISTENT');
    }

    /**
     * Test in found
     */
    public function testInFound()
    {
        $found = $this
            ->locationProvider
            ->in('ES_CA', [
                'ES',
            ]);

        $this->assertTrue(
            $found,
            'CA should be found inside ES'
        );
    }

    /**
     * Test in found with multiples possibilities
     */
    public function testInMultipleFound()
    {
        $found = $this
            ->locationProvider
            ->in('ES_CA_VO_Viladecavalls', [
                'ES_CA_VO_SantCeloni',
                'ES_CA',
            ]);

        $this->assertTrue(
            $found,
            'Viladecavalls should be found inside ES_CA'
        );
    }

    /**
     * Test in not found
     */
    public function testInNotFound()
    {
        $found = $this
            ->locationProvider
            ->in('ES', [
                'ES_CA',
            ]);

        $this->assertFalse(
            $found,
            'ES should not be found inside CA'
        );
    }

    /**
     * Test in not found for multiple options
     */
    public function testInNotFoundMultiple()
    {
        $found = $this
            ->locationProvider
            ->in('ES', [
                'ES_CA',
                'ES_CA_VO_SantCeloni',
            ]);

        $this->assertFalse(
            $found,
            'ES should not be found inside Catalunya or Sant Celoni'
        );
    }

    /**
     * Test in with a non-existent location
     */
    public function testInLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );

        $this
            ->locationProvider
            ->in('UNEXISTENT', [
                'ES_CA_VO_SantCeloni',
                'ES_CA',
            ]);
    }
}
