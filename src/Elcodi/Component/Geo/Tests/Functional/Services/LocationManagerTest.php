<?php

namespace Elcodi\Bundle\GeoBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Services\Interfaces\LocationIdentifiedCollectionInterface;
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
        $rootLocations = $this->locationManager->getRootLocations();

        $this->assertCount(
            1,
            $rootLocations,
            'We only expect one zone to be root'
        );

        /**
         * @var LocationInterface $location
         */
        $location = reset($rootLocations);
        $this->assertInstanceOf(
            'Elcodi\Component\Geo\Entity\Interfaces\LocationInterface',
            $location,
            'The response should be a LocationInterface'
        );

        $this->assertEquals(
            'Spain',
            $location->getName(),
            'Spain is the only root location'
        );
    }

    public function testGetChildren()
    {
        $locations = $this->locationManager->getChildren('ES');

        $this->assertCount(
            1,
            $locations,
            'We only expect one location to be returned'
        );

        /**
         * @var LocationInterface $children
         */
        $children = reset($locations->toArray());

        $this->assertInstanceOf(
            'Elcodi\Component\Geo\Entity\Interfaces\LocationInterface',
            $children,
            'The response should be a LocationInterface'
        );

        $this->assertEquals(
            'Catalunya',
            $children->getName(),
            'We expect only Catalunya as children of Spain'
        );
    }

    public function testGetChildrenParentNotFound()
    {
        $locations = $this->locationManager->getChildren('UNEXISTENT');

        $this->assertCount(
            0,
            $locations,
            'We only expect one location to be returned'
        );
    }

    public function testGetChildrenNotFound()
    {
        $locations = $this->locationManager->getChildren('UNEXISTENT');

        $this->assertCount(
            0,
            $locations,
            'We only expect one location to be returned'
        );
    }

    public function testGetParents()
    {
        $locations = $this->locationManager->getParents('ES_CA');

        $this->assertCount(
            1,
            $locations,
            'We only expect one location to be returned'
        );

        /**
         * @var LocationInterface $children
         */
        $children = reset($locations->toArray());

        $this->assertInstanceOf(
            'Elcodi\Component\Geo\Entity\Interfaces\LocationInterface',
            $children,
            'The response should be a LocationInterface'
        );

        $this->assertEquals(
            'Spain',
            $children->getName(),
            'We expect only Spain as parent of Catalunya'
        );
    }
}
