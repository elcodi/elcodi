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

use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuBuilder.
 */
class MenuBuilder extends AbstractMenuModifier implements MenuChangerInterface
{
    /**
     * Add menu builder.
     *
     * @param MenuBuilderInterface $menuBuilder Menu builder
     * @param array                $menus       Menus
     * @param string               $stage       Stage
     * @param int                  $priority    Priority
     *
     * @return $this Self object
     */
    public function addMenuBuilder(
        MenuBuilderInterface $menuBuilder,
        array $menus,
        $stage,
        $priority
    ) {
        $this->addElement(
            $menuBuilder,
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
        $menuBuilders = $this->getElementsByMenuCodeAndStage(
            $menu->getCode(),
            $stage
        );

        /**
         * @var MenuBuilderInterface $menuBuilder
         */
        foreach ($menuBuilders as $menuBuilder) {
            $menuBuilder->build($menu);
        }

        return $this;
    }
}
