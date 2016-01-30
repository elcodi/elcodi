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

namespace Elcodi\Component\Menu\Tests\UnitTest\Filter;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Menu\Filter\MenuDisabledFilter;

/**
 * Class MenuDisabledFilterTest.
 */
class MenuDisabledFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test filter disabled.
     *
     * @dataProvider dataFilterDisabled
     */
    public function testFilterDisabled($enabled)
    {
        $node = $this->prophesize('Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface');
        $node
            ->isEnabled()
            ->willReturn($enabled)
            ->shouldBeCalled();

        $menuDisabledFilter = new MenuDisabledFilter();
        $this->assertEquals(
            $enabled,
            $menuDisabledFilter->filter($node->reveal())
        );
    }

    /**
     * Data for test filter disabled.
     */
    public function dataFilterDisabled()
    {
        return [
            [true],
            [false],
        ];
    }
}
