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

namespace Elcodi\Component\Menu\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Filter\Interfaces\MenuFilterInterface;
use Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuFilterer.
 */
class MenuFilterer extends AbstractMenuModifier implements MenuChangerInterface
{
    /**
     * Add menu filter.
     *
     * @param MenuFilterInterface $menuFilter Menu filter
     * @param array               $menus      Menus
     * @param string              $stage      Stage
     * @param int                 $priority   Priority
     *
     * @return $this Self object
     */
    public function addMenuFilter(
        MenuFilterInterface $menuFilter,
        array $menus,
        $stage,
        $priority
    ) {
        $this->addElement(
            $menuFilter,
            $menus,
            $stage,
            $priority
        );

        return $this;
    }

    /**
     * Apply change.
     *
     * @param MenuInterface $menu  Menu
     * @param string        $stage Stage
     *
     * @return $this Self object
     */
    public function applyChange(
        MenuInterface $menu,
        $stage
    ) {
        $menu->setSubnodes(
            $this->applyFiltersToMenuNodes(
                $menu->getSubnodes(),
                $menu->getCode(),
                $stage
            )
        );

        return $this;
    }

    /**
     * Apply menu filters to Menu.
     *
     * @param ArrayCollection $menuNodes Menu nodes
     * @param string          $menuCode  Menu code
     * @param string          $stage     Stage
     *
     * @return ArrayCollection Filtered collection
     */
    private function applyFiltersToMenuNodes(
        ArrayCollection $menuNodes,
        $menuCode,
        $stage
    ) {
        return $menuNodes->filter(function (NodeInterface $menuNode) use ($menuCode, $stage) {

            if ($this->applyFiltersToMenuNode(
                $menuNode,
                $menuCode,
                $stage
            )
            ) {
                $menuNode->setSubnodes(
                    $this->applyFiltersToMenuNodes(
                        $menuNode->getSubnodes(),
                        $menuCode,
                        $stage
                    )
                );

                return true;
            }

            return false;
        });
    }

    /**
     * Apply menu filters to Menu.
     *
     * @param NodeInterface $menuNode Menu
     * @param string        $menuCode Menu code
     * @param string        $stage    Stage
     *
     * @return bool Menu node is valid
     */
    private function applyFiltersToMenuNode(
        NodeInterface $menuNode,
        $menuCode,
        $stage
    ) {
        $menuFilters = $this->getElementsByMenuCodeAndStage(
            $menuCode,
            $stage
        );

        return array_reduce(
            $menuFilters,
            function ($isValid, MenuFilterInterface $menuFilter) use ($menuNode) {

                return
                    $isValid &&
                    $menuFilter->filter($menuNode);
            },
            true
        );
    }
}
