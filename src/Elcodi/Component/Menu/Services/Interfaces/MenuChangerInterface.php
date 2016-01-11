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

namespace Elcodi\Component\Menu\Services\Interfaces;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;

/**
 * Interface MenuChangerInterface.
 */
interface MenuChangerInterface
{
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
    );
}
