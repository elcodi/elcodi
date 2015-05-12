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

namespace Elcodi\Component\Menu\Services;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Filter\Interfaces\MenuFilterInterface;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuFilterer
 */
class MenuFilterer implements MenuChangerInterface
{
    /**
     * @var MenuFilterInterface[]
     *
     * Menu filter array
     */
    protected $menuFilters;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->menuFilters = [];
    }

    /**
     * Add menu filter
     *
     * @var MenuFilterInterface $menuFilter Menu filter
     *
     * @return $this Self object
     */
    public function addMenuFilter(MenuFilterInterface $menuFilter)
    {
        $this->menuFilters[] = $menuFilter;

        return $this;
    }

    /**
     * Apply change
     *
     * @param MenuInterface $menu Menu
     *
     * @return $this Self object
     */
    public function applyChange(MenuInterface $menu)
    {
        $menuNodes = $menu->getSubnodes();

        $this->applyFiltersToMenuNodes($menuNodes);

        return $this;
    }

    /**
     * Apply menu filters to Menu
     *
     * @param Collection $menuNodes Menu nodes
     *
     * @return $this Self object
     */
    protected function applyFiltersToMenuNodes(Collection $menuNodes)
    {
        /**
         * @var NodeInterface $menuNode
         */
        foreach ($menuNodes as $menuKey => $menuNode) {
            if ($this->applyFiltersToMenuNode($menuNode)) {
                $this->applyFiltersToMenuNodes($menuNode->getSubnodes());
            } else {
                unset($menuNodes[$menuKey]);
            }
        }

        return $this;
    }

    /**
     * Apply menu filters to Menu
     *
     * @param NodeInterface $menuNode Menu
     *
     * @return boolean Menu node is valid
     */
    protected function applyFiltersToMenuNode(NodeInterface $menuNode)
    {
        return array_reduce(
            $this->menuFilters,
            function ($isValid, MenuFilterInterface $menuFilter) use ($menuNode) {

                return $isValid && $menuFilter->filter($menuNode);
            },
            true
        );
    }
}
