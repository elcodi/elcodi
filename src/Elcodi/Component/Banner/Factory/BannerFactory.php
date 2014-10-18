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

namespace Elcodi\Component\Banner\Factory;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Banner\Entity\Banner;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class Banner
 */
class BannerFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Banner New Banner instance
     */
    public function create()
    {
        /**
         * @var Banner $banner
         */
        $classNamespace = $this->getEntityNamespace();
        $banner = new $classNamespace();
        $banner
            ->setBannerZones(new ArrayCollection())
            ->setCreatedAt(new DateTime())
            ->setEnabled(false);

        return $banner;
    }
}
