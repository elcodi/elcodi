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

namespace Elcodi\Component\Menu\Event;

use RuntimeException;
use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface as MenuSerializer;

/**
 * Class MenuEvent
 *
 * @author Berny Cantos <be@rny.cc>
 */
class MenuEvent extends Event
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
     * Menu settings in an array
     */
    protected $menu;

    /**
     * @var callable[]
     *
     * Collection of filters to run
     */
    protected $filters = [];
    /**
     * @var MenuSerializer
     *
     *
     */
    private $serializer;

    /**
     * Constructor
     *
     * @param string         $menuName   Menu name
     * @param array          $menu       Menu settings
     * @param MenuSerializer $serializer Menu serializer
     */
    public function __construct($menuName, array $menu, MenuSerializer $serializer)
    {
        $this->menuName = $menuName;
        $this->menu = $menu;
        $this->serializer = $serializer;
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
     * Return current settings of the menu
     *
     * @return array
     */
    public function getMenu()
    {
        return $this->menu;
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
        $this->menu[] = $this->serializer->serialize($node);

        return $this;
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
     * Visit each node in the menu with the filters and return the result.
     *
     * @return array
     */
    public function getResult()
    {
        if (count($this->filters) === 0) {

            return $this->menu;
        }

        return $this->visitChildren($this->menu);
    }

    /**
     * Visit each children node with filters
     *
     * @param array $children Children nodes
     *
     * @return array $children Filtered children nodes
     */
    protected function visitChildren(array $children)
    {
        $subnodes = [];
        foreach ($children as $childName => $childNode) {

            foreach ($this->filters as $filter) {

                $childNode = $filter($childNode);
                if ($childNode === false) {
                    continue 2;
                }

                if (!is_array($childNode)) {

                    throw new RuntimeException(sprintf(
                        'Menu filters should return an array, but "%s" was found.',
                        gettype($childNode)
                    ));
                }
            }

            if (count($childNode['subnodes']) > 0) {
                $childNode['subnodes'] = $this->visitChildren($childNode['subnodes']);
            }

            $subnodes[$childName] = $childNode;
        }

        return $subnodes;
    }
}
