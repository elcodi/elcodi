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

namespace Elcodi\Component\Geo\Adapter\LocationProvider;

use Doctrine\ORM\EntityNotFoundException;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Factory\LocationDataFactory;
use Elcodi\Component\Geo\ValueObject\ApiUrls;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationApiProviderAdapter.
 */
class LocationApiProviderAdapter implements LocationProviderAdapterInterface
{
    /**
     * @var LocationDataFactory
     *
     * Location transformer
     */
    private $locationDataFactory;

    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    private $urlGeneratorInterface;

    /**
     * @var ApiUrls
     *
     * Api urls wrapper
     */
    private $apiUrls;

    /**
     * @var string
     *
     * Host
     */
    private $host;

    /**
     * Location to location data transformer.
     *
     * @param LocationDataFactory   $locationDataFactory   Transformer
     * @param UrlGeneratorInterface $urlGeneratorInterface Url generator
     * @param ApiUrls               $apiUrls               The api urls
     * @param string                $host                  Host
     */
    public function __construct(
        LocationDataFactory $locationDataFactory,
        UrlGeneratorInterface $urlGeneratorInterface,
        ApiUrls $apiUrls,
        $host = ''
    ) {
        $this->locationDataFactory = $locationDataFactory;
        $this->urlGeneratorInterface = $urlGeneratorInterface;
        $this->apiUrls = $apiUrls;
        $this->host = $host;
    }

    /**
     * Get all the root locations.
     *
     * @return LocationData[] Collection of locations
     */
    public function getRootLocations()
    {
        $url = $this->buildUrlByMethodName(
            'getGetRootLocationsUrl',
            []
        );

        return $this
            ->buildLocations(
                $this->resolveApiUrl($url)
            );
    }

    /**
     * Get the children given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[] Collection of locations
     */
    public function getChildren($id)
    {
        $url = $this->buildUrlByMethodName(
            'getGetChildrenUrl',
            ['id' => $id]
        );

        return $this
            ->buildLocations(
                $this->resolveApiUrl($url)
            );
    }

    /**
     * Get the parents given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[] Collection of locations
     */
    public function getParents($id)
    {
        $url = $this->buildUrlByMethodName(
            'getGetParentsUrl',
            ['id' => $id]
        );

        return $this
            ->buildLocations(
                $this->resolveApiUrl($url)
            );
    }

    /**
     * Get the full location info given it's id.
     *
     * @param string $id The location id.
     *
     * @return LocationData Location info
     */
    public function getLocation($id)
    {
        $url = $this->buildUrlByMethodName(
            'getGetLocationUrl',
            ['id' => $id]
        );

        return $this
            ->buildLocation(
                $this->resolveApiUrl($url)
            );
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
     *
     * @param string $id The location id.
     *
     * @return LocationData[] Collection of locations
     */
    public function getHierarchy($id)
    {
        $url = $this->buildUrlByMethodName(
            'getGetHierarchyUrl',
            ['id' => $id]
        );

        return $this
            ->buildLocations(
                $this->resolveApiUrl($url)
            );
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter.
     *
     * @param string $id  The location Id
     * @param array  $ids The location Ids
     *
     * @return bool Location is container
     */
    public function in($id, array $ids)
    {
        $url = $this->buildUrlByMethodName(
            'getInUrl',
            [
                'id' => $id,
                'ids' => implode(',', $ids),
            ]
        );

        $response = $this->resolveApiUrl($url);

        return $response['result'];
    }

    /**
     * Given a method of the ApiUrls value object and a parameters for the route
     * construction, return url.
     *
     * @param string $method     Method to be called for the url name
     * @param array  $parameters Parameters for the url construction
     *
     * @return string Url
     */
    private function buildUrlByMethodName($method, array $parameters)
    {
        $url = $this
            ->apiUrls
            ->$method();

        return $this->host
            ? $this->buildUrlWithHost(
                $url,
                $parameters
            )
            : $this->buildUrlWithoutHost(
                $url,
                $parameters
            );
    }

    /**
     * Given an url, return the complete route using host.
     *
     * @param string $url        Url to be called
     * @param array  $parameters Parameters for the url construction
     *
     * @return string Url
     */
    private function buildUrlWithHost($url, array $parameters)
    {
        return
            trim($this->host, '/') .
            '/' .
            ltrim(
                $this
                    ->urlGeneratorInterface
                    ->generate(
                        $url,
                        $parameters,
                        UrlGeneratorInterface::ABSOLUTE_PATH
                    ), '/'
            );
    }

    /**
     * Given an url, return the complete route in ab absolute way.
     *
     * @param string $url        Url to be called
     * @param array  $parameters Parameters for the url construction
     *
     * @return string Url
     */
    private function buildUrlWithoutHost($url, array $parameters)
    {
        return $this
            ->urlGeneratorInterface
            ->generate(
                $url,
                $parameters,
                UrlGeneratorInterface::ABSOLUTE_URL
            );
    }

    /**
     * Call given url, unpack the response and look for possible api exceptions.
     *
     * @param string $url Url where to call
     *
     * @return array Response unpacked
     *
     * @throws EntityNotFoundException Entity not found
     * @throws HttpException           Http Exception
     */
    private function resolveApiUrl($url)
    {
        $client = new Client([
            'defaults' => [
                'timeout' => 5,
            ],
        ]);
        $response = $client->get($url);
        $responseStatusCode = $response->getStatusCode();

        if (404 == $responseStatusCode) {
            throw new EntityNotFoundException();
        }

        if (500 == $responseStatusCode) {
            throw new HttpException('Http exception');
        }

        return $response->json(['object' => false]);
    }

    /**
     * Build a new set of Location instances given some data.
     *
     * @param array $data Data where to build from
     *
     * @return LocationData[] Location instances
     */
    private function buildLocations(array $data)
    {
        $locationInstances = [];

        foreach ($data as $locationData) {
            $locationInstances[] = $this->buildLocation($locationData);
        }

        return $locationInstances;
    }

    /**
     * Build a new Location instance given some data.
     *
     * @param array $data Data where to build from
     *
     * @return LocationData Location instance
     */
    private function buildLocation(array $data)
    {
        return $this
            ->locationDataFactory
            ->create(
                $data['id'],
                $data['name'],
                $data['code'],
                $data['type']
            );
    }
}
