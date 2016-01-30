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

namespace Elcodi\Component\Menu\Tests\UnitTest\Entity\Menu;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Menu\Entity\Menu\Node;

/**
 * Class NodeTest.
 */
class NodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test isActive with non matching urls.
     */
    public function testIsActive()
    {
        $node = new Node();
        $this->assertFalse($node->isActive('whatever'));
        $node->setActiveUrls([
            'http://localhost:0001',
            'http://localhost:0002',
        ]);

        $this->assertFalse($node->isActive('http://localhost:0000'));
        $this->assertTrue($node->isActive('http://localhost:0001'));
    }

    /**
     * Test IsExpanded.
     */
    public function testIsExpanded()
    {
        $node = new Node();
        $this->assertFalse($node->isExpanded('whatever'));
        $anotherNode = new Node();
        $anotherNode->setActiveUrls([
            'http://localhost:0001',
            'http://localhost:0002',
        ]);
        $this->assertFalse($node->isExpanded('http://localhost:0001'));
        $node->setSubnodes(new ArrayCollection());
        $node->addSubnode($anotherNode);
        $this->assertFalse($node->isExpanded('http://localhost:0000'));
        $this->assertTrue($node->isExpanded('http://localhost:0001'));
    }
}
