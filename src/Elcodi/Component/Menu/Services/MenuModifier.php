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
use Elcodi\Component\Menu\Modifier\Interfaces\MenuModifierInterface;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuModifier
 */
class MenuModifier implements MenuChangerInterface
{
    /**
     * @var MenuModifierInterface[]
     *
     * Menu modifier array
     */
    protected $menuModifiers;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->menuModifiers = [];
    }

    /**
     * Add menu modifier
     *
     * @var MenuModifierInterface $menuModifier Menu modifier
     *
     * @return $this Self object
     */
    public function addMenuModifier(MenuModifierInterface $menuModifier)
    {
        $this->menuModifiers[] = $menuModifier;

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

        $this->applyModifiersToMenuNodes($menuNodes);

        return $this;
    }

    /**
     * Apply menu filters to Menu
     *
     * @param Collection $menuNodes Menu nodes
     *
     * @return $this Self object
     */
    protected function applyModifiersToMenuNodes(Collection $menuNodes)
    {
        $menuNodes->forAll(function ($_, NodeInterface $menuNode) {

            $this->applyModifiersToMenuNodes($menuNode->getSubnodes());
            foreach ($this->menuModifiers as $menuModifier) {
                $menuModifier->modify($menuNode);
            }
        });

        return $this;
    }
}
