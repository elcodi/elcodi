<?php

namespace Elcodi\Bundle\GeoBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Geo\ValueObject\LocationData;
use Elcodi\Component\Geo\Services\LocationManager;

class LocationManagerTest extends WebTestCase
{
    /**
     * @var LocationManager
     *
     * LocationManager class
     */
    protected $locationManager;

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi.location_manager.service'];
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
         * @var LocationManager $locationManager
         */
        $this->locationManager = $this
            ->get('elcodi.location_manager.service');
    }

    /**
     * Test that we are returning the root locations
     */
    public function testGetRootLocations()
    {
        $rootLocations = $this
            ->locationManager
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

    public function testGetChildren()
    {
        $locations = $this
            ->locationManager
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

    public function testGetChildrenLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );
        $this->locationManager->getChildren('UNEXISTENT');
    }

    public function testGetChildrenNotFound()
    {
        $locations = $this
            ->locationManager
            ->getChildren('ES_CA_VO_SantCeloni');

        $this->assertCount(
            0,
            $locations,
            'We don\'t expect any location to be returned'
        );
    }

    public function testGetParents()
    {
        $locations = $this
            ->locationManager
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

    public function testGetParentsLocationNotFound()
    {
        $this->setExpectedException(
            'Doctrine\ORM\EntityNotFoundException',
            'Entity was not found.'
        );
        $this->locationManager->getParents('UNEXISTENT');
    }

    public function testGetParentsNotFound()
    {
        $locations = $this->locationManager->getParents('ES');

        $this->assertCount(
            0,
            $locations,
            'We don\'t expect any location to be returned'
        );
    }

    public function testGetLocation()
    {
        $location = $this->locationManager->getLocation('ES_CA');

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

    public function testGetHierarchy()
    {
        $hierarchy = $this
            ->locationManager
            ->getHierarchy('ES_CA_VO_SantCeloni');

        $expectedHierarchyNames = array(
            'Spain',
            'Catalunya',
            'Valles Oriental',
            'Sant Celoni',
        );

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

    public function testInFound()
    {
        $found = $this->locationManager->in('ES_CA',['ES']);

        $this->assertTrue($found, 'CA should be found inside ES');
    }

    public function testInNotFound()
    {
        $found = $this->locationManager->in('ES',['ES_CA']);

        $this->assertFalse($found, 'ES should not be found inside CA');
    }
}
