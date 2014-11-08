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

namespace Elcodi\Component\Page\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Page\Entity\Interfaces\RoutableInterface;
use Elcodi\Component\Page\Repository\Interfaces\RoutableRepositoryInterface;

/**
 * Class PageRepository
 *
 * @author Jonas HAOUZI <haouzijonas@gmail.com>
 * @author Àlex Corretgé <alex@corretge.cat>
 * @author Berny Cantos <be@rny.cc>
 */
class PageRepository extends EntityRepository implements RoutableRepositoryInterface
{
    /**
     * @param string $path
     * @return RoutableInterface
     */
    public function findOneByPath($path)
    {
        return parent::findOneBy(array(
            'path' => $path,
        ));
    }
}
