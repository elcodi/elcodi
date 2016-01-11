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

namespace Elcodi\Component\Menu\Tests\UnitTest\Services\Abstracts;

use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Class AbstractMenuModifierTest.
 */
class AbstractMenuModifierTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test when none menu is specified.
     */
    public function testNoMenuAssigned()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $element1 = (object) [];
        $menuModifier->addElement(
            $element1,
            [],
            'pre'
        );
        $elements = $menuModifier->getElementsByMenuCodeAndStage('menu1', 'pre');

        $this->assertCount(1, $elements);
        $this->assertEquals($element1, $elements[0]);
    }

    /**
     * Test when one menu is assigned as an individual string.
     */
    public function testOneSingleMenuAssigned()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $element1 = (object) [];
        $menuModifier->addElement(
            $element1,
            'menu1',
            'pre'
        );
        $elements = $menuModifier->getElementsByMenuCodeAndStage('menu1', 'pre');

        $this->assertCount(1, $elements);
        $this->assertEquals($element1, $elements[0]);

        $this->assertEmpty(
            $menuModifier->getElementsByMenuCodeAndStage('menu2', 'pre')
        );
    }

    /**
     * Test when several menus are assigned as an array.
     */
    public function testSeveralMenusAssigned()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $element1 = (object) [];
        $menuModifier->addElement(
            $element1,
            ['menu1', 'menu2'],
            'pre'
        );
        $elements = $menuModifier->getElementsByMenuCodeAndStage('menu1', 'pre');

        $this->assertCount(1, $elements);
        $this->assertEquals($element1, $elements[0]);

        $this->assertNotEmpty(
            $menuModifier->getElementsByMenuCodeAndStage('menu2', 'pre')
        );

        $this->assertEmpty(
            $menuModifier->getElementsByMenuCodeAndStage('menu3', 'pre')
        );
    }

    /**
     * Test stage definition.
     */
    public function testStage()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $element1 = (object) [];
        $menuModifier->addElement(
            $element1,
            [],
            'pre'
        );
        $elements = $menuModifier->getElementsByMenuCodeAndStage('menu1', 'pre');

        $this->assertCount(1, $elements);
        $this->assertEquals($element1, $elements[0]);

        $this->assertEmpty(
            $menuModifier->getElementsByMenuCodeAndStage('menu3', 'post')
        );
    }

    /**
     * Test stage definition in big scenario.
     */
    public function testStageWithMenus()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $menuModifier
            ->addElement((object) [], [], 'pre')
            ->addElement((object) [], ['menu1'], 'pre')
            ->addElement((object) [], 'menu2', 'post')
            ->addElement((object) [], 'menu1', 'post')
            ->addElement((object) [], ['menu2', 'menu3'], 'pre');

        $this->assertCount(
            2,
            $menuModifier->getElementsByMenuCodeAndStage('menu2', 'pre')
        );

        $this->assertCount(
            1,
            $menuModifier->getElementsByMenuCodeAndStage('menu1', 'post')
        );

        $this->assertEmpty(
            $menuModifier->getElementsByMenuCodeAndStage('menu3', 'post')
        );
    }

    /**
     * Test priorities.
     */
    public function testPriorities()
    {
        $menuModifier = $this->getMockForAbstractClass(
            'Elcodi\Component\Menu\Services\Abstracts\AbstractMenuModifier'
        );

        $object1 = new stdClass();
        $object1->id = 1;

        $object2 = new stdClass();
        $object2->id = 2;

        $object3 = new stdClass();
        $object3->id = 3;

        $object4 = new stdClass();
        $object4->id = 4;

        $menuModifier
            ->addElement($object1, [], 'pre', 3)
            ->addElement($object2, [], 'pre', 7)
            ->addElement($object3, [], 'pre', 0)
            ->addElement($object4, [], 'pre', 4);

        $elements = $menuModifier->getElementsByMenuCodeAndStage('menu1', 'pre');

        $this->assertEquals(2, $elements[0]->id);
        $this->assertEquals(4, $elements[1]->id);
        $this->assertEquals(1, $elements[2]->id);
        $this->assertEquals(3, $elements[3]->id);
    }
}
