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

namespace Elcodi\Component\Geo\ValueObject;

/**
 * Class ApiUrls.
 */
class ApiUrls
{
    /**
     * @var string
     *
     * getRootLocations url
     */
    private $getRootLocationsUrl;

    /**
     * @var string
     *
     * getChildren url
     */
    private $getChildrenUrl;

    /**
     * @var string
     *
     * getParents url
     */
    private $getParentsUrl;

    /**
     * @var string
     *
     * getLocation url
     */
    private $getLocationUrl;

    /**
     * @var string
     *
     * getHierarchy url
     */
    private $getHierarchyUrl;

    /**
     * @var string
     *
     * in url
     */
    private $inUrl;

    /**
     * Create new Api url.
     *
     * @param string $getRootLocationsUrl getRootLocations url
     * @param string $getChildrenUrl      getChildren url
     * @param string $getParentsUrl       getParents url
     * @param string $getLocationUrl      getLocation url
     * @param string $getHierarchyUrl     getHierarchy url
     * @param string $inUrl               in url
     */
    public function __construct(
        $getRootLocationsUrl,
        $getChildrenUrl,
        $getParentsUrl,
        $getLocationUrl,
        $getHierarchyUrl,
        $inUrl
    ) {
        $this->getRootLocationsUrl = $getRootLocationsUrl;
        $this->getChildrenUrl = $getChildrenUrl;
        $this->getParentsUrl = $getParentsUrl;
        $this->getLocationUrl = $getLocationUrl;
        $this->getHierarchyUrl = $getHierarchyUrl;
        $this->inUrl = $inUrl;
    }

    /**
     * Get GetRootLocationsUrl.
     *
     * @return string GetRootLocationsUrl
     */
    public function getGetRootLocationsUrl()
    {
        return $this->getRootLocationsUrl;
    }

    /**
     * Get GetChildrenUrl.
     *
     * @return string GetChildrenUrl
     */
    public function getGetChildrenUrl()
    {
        return $this->getChildrenUrl;
    }

    /**
     * Get GetParentsUrl.
     *
     * @return string GetParentsUrl
     */
    public function getGetParentsUrl()
    {
        return $this->getParentsUrl;
    }

    /**
     * Get GetLocationUrl.
     *
     * @return string GetLocationUrl
     */
    public function getGetLocationUrl()
    {
        return $this->getLocationUrl;
    }

    /**
     * Get GetHierarchyUrl.
     *
     * @return string GetHierarchyUrl
     */
    public function getGetHierarchyUrl()
    {
        return $this->getHierarchyUrl;
    }

    /**
     * Get InUrl.
     *
     * @return string InUrl
     */
    public function getInUrl()
    {
        return $this->inUrl;
    }
}
