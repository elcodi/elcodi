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

namespace Elcodi\Component\Menu\Tests\Entity\Menu;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Menu\Entity\Menu\Node;

class NodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Node
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Node();
    }

    public function testCode()
    {
        $code = sha1(rand());

        $setterOutput = $this->object->setCode($code);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCode();
        $this->assertSame($code, $getterOutput);
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testUrl()
    {
        $url = 'http://www.example.com/';

        $setterOutput = $this->object->setUrl($url);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getUrl();
        $this->assertSame($url, $getterOutput);
    }

    public function testActiveUrls()
    {
        $activeUrls = range('a', 'z');

        $setterOutput = $this->object->setActiveUrls($activeUrls);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getActiveUrls();
        $this->assertSame($activeUrls, $getterOutput);

        $newActiveUrl = 'foo';

        // add a new ActiveUrl
        $setterOutput = $this->object->addActiveUrl($newActiveUrl);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getActiveUrls();
        $this->assertContains($newActiveUrl, $getterOutput);

        // remove new ActiveUrl
        $setterOutput = $this->object->removeActiveUrl($newActiveUrl);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getActiveUrls();
        $this->assertNotContains($newActiveUrl, $getterOutput);
    }

    public function testTag()
    {
        $tag = sha1(rand());

        $setterOutput = $this->object->setTag($tag);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTag();
        $this->assertSame($tag, $getterOutput);
    }

    public function testPriority()
    {
        $priority = rand();

        $setterOutput = $this->object->setPriority($priority);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPriority();
        $this->assertSame($priority, $getterOutput);
    }

    public function testIsActive()
    {
        $url = 'http://www.example.com/';

        $this->assertFalse($this->object->isActive($url));

        $setterOutput = $this->object->setUrl($url);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertTrue($this->object->isActive($url));
    }

    public function testIsExpanded()
    {
        $url = 'http://www.example.com/';

        $this->assertFalse($this->object->isExpanded($url));

        $setterOutput = $this->object->setUrl($url);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertTrue($this->object->isExpanded($url));
    }

    public function testWarnings()
    {
        $warnings = rand();

        $setterOutput = $this->object->setWarnings($warnings);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getWarnings();
        $this->assertSame($warnings, $getterOutput);
    }

    public function testIncrementWarnings()
    {
        $setterOutput = $this->object->incrementWarnings();
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame(1, $this->object->getWarnings());

        $warnings = rand();

        $setterOutput = $this->object->setWarnings($warnings);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $setterOutput = $this->object->incrementWarnings();
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($warnings + 1, $this->object->getWarnings());
    }
}
