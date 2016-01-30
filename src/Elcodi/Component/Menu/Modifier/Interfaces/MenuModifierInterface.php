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

namespace Elcodi\Component\Menu\Modifier\Interfaces;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;

/**
 * Interface MenuModifierInterface.
 */
interface MenuModifierInterface
{
    /**
     * Modifier the menu node.
     *
     * @param NodeInterface $menuNode Menu node
     */
    public function modify(NodeInterface $menuNode);
}
