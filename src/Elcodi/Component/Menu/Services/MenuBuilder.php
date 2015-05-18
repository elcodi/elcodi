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

use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuBuilder
 */
class MenuBuilder implements MenuChangerInterface
{
    /**
     * @var MenuBuilderInterface[]
     *
     * Menu builder array
     */
    protected $menuBuilders;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->menuBuilders = [];
    }

    /**
     * Add menu builder
     *
     * @var MenuBuilderInterface $menuBuilder Menu builder
     *
     * @return $this Self object
     */
    public function addMenuBuilder(MenuBuilderInterface $menuBuilder)
    {
        $this->menuBuilders[] = $menuBuilder;

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
        foreach ($this->menuBuilders as $menuBuilder) {
            $menuBuilder->build($menu);
        }

        return $this;
    }
}
