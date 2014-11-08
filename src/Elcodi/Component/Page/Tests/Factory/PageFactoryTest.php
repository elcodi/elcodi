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

namespace Elcodi\Component\Page\Tests\Factory;

use Elcodi\Component\Page\Factory\PageFactory;

/**
 * Class PageFactoryTest
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 */
class PageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateReturnAPage()
    {
        $factory = new PageFactory();

        $result = $factory->create("A title", "Some conent", "/the-path");

        $this->assertInstanceOf('Elcodi\Component\Page\Entity\Interfaces\PageInterface', $result);
    }
}
