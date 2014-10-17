<?php

/**
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

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Banner\Entity\Banner;
use Elcodi\Component\Banner\Entity\BannerZone;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * BannerZone Factory
 */
class BannerZoneFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Banner New BannerZone instance
     */
    public function create()
    {
        /**
         * @var BannerZone $bannerZone
         */
        $classNamespace = $this->getEntityNamespace();
        $bannerZone = new $classNamespace();
        $bannerZone->setBanners(new ArrayCollection());

        return $bannerZone;
    }
}
