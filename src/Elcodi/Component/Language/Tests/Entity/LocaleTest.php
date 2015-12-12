<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Language\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Language\Entity\Locale;

class LocaleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Locale
     */
    protected $object;

    /**
     * @var string
     */
    private $localeIso;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->localeIso = sha1(rand());

        $this->object = new Locale($this->localeIso);
    }

    public function testGetIso()
    {
        $this->assertSame($this->localeIso, $this->object->getIso());
    }

    public function testCreate()
    {
        $localeIso = sha1(rand());

        $created = Locale::create($localeIso);

        $this->assertInstanceOf(get_class($this->object), $created);
        $this->assertSame($localeIso, $created->getIso());
    }
}
