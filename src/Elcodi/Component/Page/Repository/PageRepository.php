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

use Elcodi\Component\Page\Repository\Interfaces\RoutableRepositoryInterface;

class PageRepository extends EntityRepository implements RoutableRepositoryInterface
{
    public function findOneByPath($path)
    {
        return parent::findBy(array(
            'path' => $path,
        ));
    }
}
