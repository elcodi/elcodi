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

namespace Elcodi\Component\Geo\Services;

use Doctrine\ORM\EntityNotFoundException;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Elcodi\Component\Geo\Factory\LocationDataFactory;
use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\ApiUrls;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationApiProvider
 */
class LocationApiProvider implements LocationProviderInterface
{
    /**
     * @var LocationDataFactory
     *
     * Location transformer
     */
    protected $locationDataFactory;

    /**
     * @var ApiUrls
     *
     * Api urls wrapper
     */
    protected $apiUrls;

    /**
     * Location to location data transformer
     *
     * @param LocationDataFactory $locationDataFactory Transformer
     */
    public function __construct(
        LocationDataFactory $locationDataFactory,
        ApiUrls $apiUrls
    ) {
        $this->locationDataFactory = $locationDataFactory;
        $this->apiUrls = $apiUrls;
    }

    /**
     * Get all the root locations.
     *
     * @return LocationData[]
     */
    public function getRootLocations()
    {
        $url = $this
            ->apiUrls
            ->getGetRootLocationsUrl();

        return $this->getDataFromApi($url);
    }

    /**
     * Get the children given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[]
     */
    public function getChildren($id)
    {
        $url = $this
            ->apiUrls
            ->getGetChildrenUrl().'?id='.$id;

        return $this->getDataFromApi($url);
    }

    /**
     * Get the parents given a location id.
     *
     * @param string $id The location Id.
     *
     * @return LocationData[]
     */
    public function getParents($id)
    {
        $url = $this
            ->apiUrls
            ->getGetParentsUrl().'?id='.$id;

        return $this->getDataFromApi($url);
    }

    /**
     * Get the full location info given it's id.
     *
     * @param string $id The location id.
     *
     * @return LocationData
     */
    public function getLocation($id)
    {
        $url = $this
            ->apiUrls
            ->getGetLocationUrl().'?id='.$id;

        return $this->getDataFromApi($url);
    }

    /**
     * Get the hierarchy given a location sorted from root to the given
     * location.
     *
     * @param string $id The location id.
     *
     * @return LocationData
     */
    public function getHierarchy($id)
    {
        $url = $this
            ->apiUrls
            ->getGetHierarchyUrl().'?id='.$id;

        return $this->getDataFromApi($url);
    }

    /**
     * Checks if the first received id is contained between the rest of ids
     * received as second parameter
     *
     * @param string $id  The location Id
     * @param array  $ids The location Ids
     *
     * @return boolean
     */
    public function in($id, array $ids)
    {
        $url = $this
            ->apiUrls
            ->getInUrl().'?id='.$id.'&ids='.implode(',', $ids);

        return $this->getDataFromApi($url);
    }

    /**
     * Get content from specific url in a PHP format
     *
     * @param string $url Url where to call
     *
     * @return LocationData[] Location data
     *
     * @throws EntityNotFoundException Entity not found
     * @throws HttpException           Http Exception
     */
    protected function getDataFromApi($url)
    {
        $client = new Client();
        $response = $client->get($url);
        $responseStatusCode = $response->getStatusCode();

        if (404 == $responseStatusCode) {
            throw new EntityNotFoundException();
        }

        if (500 == $responseStatusCode) {
            throw new HttpException('Http exception');
        }

        $locationDataArray = [];

        foreach ($response->json(['object' => false]) as $locationResponse) {
            $locationDataArray[] = $this
                ->locationDataFactory
                ->create(
                    $locationResponse['id'],
                    $locationResponse['name'],
                    $locationResponse['code'],
                    $locationResponse['type']
                );
        }

        return $locationDataArray;
    }
}
