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

namespace Elcodi\Component\Menu\Entity\Menu;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Traits\SubnodesTrait;

/**
 * Class Node.
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
     * @var string
     *
     * Tag
     */
    protected $tag;

    /**
     * @var int
     *
     * Priority
     */
    protected $priority;

    /**
     * @var int
     *
     * Warnings
     */
    protected $warnings;

    /**
     * Gets Node code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Node code.
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
     * Sets Node name.
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
     * Gets Node name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Node URL.
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
     * Gets Node url.
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
     * @return array The Active urls
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
        $activeUrls = json_decode($this->activeUrls, true);
        $activeUrls[] = $activeUrl;
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
        $activeUrls = json_decode($this->activeUrls, true);
        $positionFound = array_search($activeUrl, $activeUrls);
        if ($positionFound) {
            unset($activeUrls[$positionFound]);
            $this->activeUrls = json_encode($activeUrls);
        }

        return $this;
    }

    /**
     * Get Tag.
     *
     * @return string Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets Tag.
     *
     * @param string $tag Tag
     *
     * @return $this Self object
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get Priority.
     *
     * @return int Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Sets Priority.
     *
     * @param int $priority Priority
     *
     * @return $this Self object
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Is active.
     *
     * A menu node is considered active when the current url and the internal
     * node url is the same.
     *
     * @param string $currentUrl Current Url
     *
     * @return bool Menu node is active
     */
    public function isActive($currentUrl)
    {
        $activeUrls = $this->getActiveUrls();

        return
            $currentUrl == $this->url ||
            (
                is_array($activeUrls) &&
                in_array($currentUrl, $this->getActiveUrls())
            );
    }

    /**
     * Is expanded.
     *
     * A menu node is considered expanded when any of their children is active
     * or expanded
     *
     * @param string $currentUrl Current Url
     *
     * @return bool Menu Node is expanded
     */
    public function isExpanded($currentUrl)
    {
        if (!$this->subnodes instanceof Collection) {
            return false;
        }

        return $this
            ->subnodes
            ->exists(function ($_, NodeInterface $node) use ($currentUrl) {

                return
                    $node->isActive($currentUrl) ||
                    $node->isExpanded($currentUrl);
            });
    }

    /**
     * Set warnings.
     *
     * @param int $warnings Warnings
     *
     * @return $this Self object
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get warnings.
     *
     * @return int Warnings
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Increment warnings.
     *
     * @param int $warnings Warnings to be incremented
     *
     * @return $this Self object
     */
    public function incrementWarnings($warnings = 1)
    {
        $this->warnings += (int) $warnings;

        return $this;
    }
}
