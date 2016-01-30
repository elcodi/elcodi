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

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Modifier\Interfaces\MenuModifierInterface;
use Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuModifier.
 */
class MenuModifier extends AbstractMenuModifier implements MenuChangerInterface
{
    /**
     * Add menu builder.
     *
     * @param MenuModifierInterface $menuModifier Menu modifier
     * @param array                 $menus        Menus
     * @param string                $stage        Stage
     * @param int                   $priority     Priority
     *
     * @return $this Self object
     */
    public function addMenuBuilder(
        MenuModifierInterface $menuModifier,
        array $menus,
        $stage,
        $priority
    ) {
        $this->addElement(
            $menuModifier,
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
        $this->applyModifiersToMenuNodes(
            $menu->getSubnodes(),
            $menu->getCode(),
            $stage
        );

        return $this;
    }

    /**
     * Apply menu filters to Menu.
     *
     * @param Collection $menuNodes Menu nodes
     * @param string     $menuCode  Menu code
     * @param string     $stage     Stage
     *
     * @return $this Self object
     */
    private function applyModifiersToMenuNodes(
        Collection $menuNodes,
        $menuCode,
        $stage
    ) {
        $menuNodes->map(function (NodeInterface $menuNode) use ($menuCode, $stage) {

            $this->applyModifiersToMenuNodes(
                $menuNode->getSubnodes(),
                $menuCode,
                $stage
            );

            $menuModifiers = $this->getElementsByMenuCodeAndStage(
                $menuCode,
                $stage
            );

            /**
             * @var MenuModifierInterface $menuModifier
             */
            foreach ($menuModifiers as $menuModifier) {
                $menuModifier->modify($menuNode);
            }
        });

        return $this;
    }
}
