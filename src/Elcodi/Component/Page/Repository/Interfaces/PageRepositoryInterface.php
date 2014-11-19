<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Page\Repository\Interfaces;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Interface PageRepositoryInterface
 *
 * @author Jonas HAOUZI <haouzijonas@gmail.com>
 * @author Àlex Corretgé <alex@corretge.cat>
 * @author Berny Cantos <be@rny.cc>
 */
interface PageRepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return PageInterface
     */
    public function findOneById($id);

    /**
     * @param string $path
     *
     * @return PageInterface
     */
    public function findOneByPath($path);
}
