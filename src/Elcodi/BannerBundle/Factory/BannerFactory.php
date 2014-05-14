<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\BannerBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\BannerBundle\Entity\Banner;

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
            ->setBannerZones(new ArrayCollection)
            ->setCreatedAt(new DateTime)
            ->setEnabled(false);

        return $banner;
    }
}
