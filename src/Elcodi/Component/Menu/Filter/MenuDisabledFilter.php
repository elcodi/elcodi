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

namespace Elcodi\Component\Menu\Filter;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Filter\Interfaces\MenuFilterInterface;

/**
 * Class MenuDisabledFilter.
 */
class MenuDisabledFilter implements MenuFilterInterface
{
    /**
     * Filter all disabled nodes.
     *
     * @param NodeInterface $menuNode Menu node
     *
     * @return bool Node must be rendered
     */
    public function filter(NodeInterface $menuNode)
    {
        return $menuNode->isEnabled();
    }
}
