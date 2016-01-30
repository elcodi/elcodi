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

namespace Elcodi\Component\Page\Tests\Factory;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Page\Factory\PageFactory;

/**
 * Class PageFactoryTest.
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 * @author Berny Cantos <be@rny.cc>
 */
class PageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateReturnAPage()
    {
        $entityName = 'Elcodi\Component\Page\Entity\Page';

        $factory = new PageFactory();
        $factory->setEntityNamespace($entityName);
        $factory->setDateTimeFactory(new DateTimeFactory());

        $result = $factory->create();

        $this->assertInstanceOf($entityName, $result);
    }
}
