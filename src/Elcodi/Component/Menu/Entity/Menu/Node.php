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

namespace Elcodi\Component\Menu\Entity\Menu;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Traits\SubnodesTrait;

/**
 * Class Node
 */
class Node implements NodeInterface
{
    use IdentifiableTrait,
        SubnodesTrait,
        EnabledTrait;

    /**
     * @var string
     *
     * Node code or short name
     */
    protected $code;

    /**
     * @var string
     *
     * Node name
     */
    protected $name;

    /**
     * @var string
     *
     * url
     */
    protected $url;

    /**
     * @var string
     *
     * Active urls
     */
    protected $activeUrls;

    /**
     * @var boolean
     *
     * Active. This value is not persisted
     */
    protected $active;

    /**
     * @var boolean
     *
     * Expanded. This value is not persisted
     */
    protected $expanded;

    /**
     * Gets Node code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Node code
     *
     * @param string $code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Sets Node name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets Node name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Node URL
     *
     * Can be a plain URL or a route name
     *
     * @param string $url Url
     *
     * @return $this Self object
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets Node url
     *
     * @return string Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set active urls.
     *
     * @param array $activeUrls Active urls
     *
     * @return $this Self object
     */
    public function setActiveUrls(array $activeUrls)
    {
        $this->activeUrls = json_encode($activeUrls);

        return $this;
    }

    /**
     * Get the active urls.
     *
     * @return Collection The Active urls
     */
    public function getActiveUrls()
    {
        return json_decode($this->activeUrls, true);
    }

    /**
     * Add an active url.
     *
     * @param string $activeUrl The active url.
     *
     * @return $this Self object
     */
    public function addActiveUrl($activeUrl)
    {
        $activeUrls       = json_decode($this->activeUrls, true);
        $activeUrls[]     = $activeUrl;
        $this->activeUrls = json_encode($activeUrls);

        return $this;
    }

    /**
     * Remove an active url.
     *
     * @param string $activeUrl The active url.
     *
     * @return $this Self object
     */
    public function removeActiveUrl($activeUrl)
    {
        $activeUrls    = json_decode($this->activeUrls, true);
        $positionFound = array_search($activeUrl, $activeUrls);

        if ($positionFound) {
            unset($activeUrls[$positionFound]);

            $this->activeUrls = json_encode($activeUrls);
        }

        return $this;
    }

    /**
     * Get Active
     *
     * @return boolean Active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets Active
     *
     * @param boolean $active Active
     *
     * @return $this Self object
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get Expanded
     *
     * @return boolean Expanded
     */
    public function getExpanded()
    {
        return $this->expanded;
    }

    /**
     * Sets Expanded
     *
     * @param boolean $expanded Expanded
     *
     * @return $this Self object
     */
    public function setExpanded($expanded)
    {
        $this->expanded = $expanded;

        return $this;
    }
}
