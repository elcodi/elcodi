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

namespace Elcodi\Component\Banner\Tests\UnitTest\Factory;

use Elcodi\Component\Core\Tests\UnitTest\Factory\Abstracts\AbstractFactoryTest;

/**
 * Class BannerZoneFactoryTest.
 */
class BannerZoneFactoryTest extends AbstractFactoryTest
{
    /**
     * Return the factory namespace.
     *
     * @return string Factory namespace
     */
    public function getFactoryNamespace()
    {
        return 'Elcodi\Component\Banner\Factory\BannerZoneFactory';
    }

    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Banner\Entity\BannerZone';
    }
}
