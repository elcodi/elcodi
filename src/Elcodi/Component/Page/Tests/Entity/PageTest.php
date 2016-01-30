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

namespace Elcodi\Component\Page\Tests\Entity;

use Elcodi\Component\Page\Entity\Page;

/**
 * Class PageTest.
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 * @author Berny Cantos <be@rny.cc>
 */
class PageTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $page = new Page();
        $title = 'Contact page title';

        $this->assertSame($page, $page->setTitle($title));
        $this->assertEquals($title, $page->getTitle());
    }

    public function testPath()
    {
        $page = new Page();
        $path = '/path/to/contact';

        $this->assertSame($page, $page->setPath($path));
        $this->assertEquals($path, $page->getPath());
    }

    public function testContent()
    {
        $page = new Page();
        $content = 'This is the content of the contact page.';

        $this->assertSame($page, $page->setContent($content));
        $this->assertEquals($content, $page->getContent());
    }

    public function persistentProvider()
    {
        return [
            'The page is persistent' => [true],
            'The page is not persistent' => [false],
        ];
    }

    /**
     * @dataProvider persistentProvider
     *
     * @param bool $persistent The persistence of the page
     */
    public function testPersistent($persistent)
    {
        $page = new Page();

        $this->assertSame($page, $page->setPersistent($persistent));
        $this->assertEquals($persistent, $page->isPersistent());
    }
}
