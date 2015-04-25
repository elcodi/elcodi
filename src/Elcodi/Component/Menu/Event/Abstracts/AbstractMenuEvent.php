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

namespace Elcodi\Component\Menu\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;

/**
 * Class AbstractMenuEvent
 */
class AbstractMenuEvent extends Event
{
    /**
     * @var string
     *
     * Menu name
     */
    protected $menuName;

    /**
     * @var array
     *
     * Menu nodes
     */
    protected $nodes;

    /**
     * @var callable[]
     *
     * Collection of filters to run
     */
    protected $filters;

    /**
     * Constructor
     *
     * @param string $menuName Menu name
     * @param array  $nodes    Menu nodes
     */
    public function __construct($menuName, array $nodes)
    {
        $this->menuName = $menuName;
        $this->nodes = $nodes;
        $this->filters = [];
    }

    /**
     * Return current menu name
     *
     * @return string
     */
    public function getMenuName()
    {
        return $this->menuName;
    }

    /**
     * Add a new node to the menu
     *
     * @param NodeInterface $node Menu node to add
     *
     * @return $this Self object
     */
    public function addNode(NodeInterface $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * Return menu nodes
     *
     * @return array
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Add a filter to process each node in the menu
     *
     * @param callable $callback
     *
     * @return $this Self object
     */
    public function addFilter(callable $callback)
    {
        $this->filters[] = $callback;

        return $this;
    }

    /**
     * Get Filters
     *
     * @return callable[] Filters
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
