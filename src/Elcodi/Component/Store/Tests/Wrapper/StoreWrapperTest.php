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

namespace Elcodi\Component\Store\Tests\Wrapper;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Store\Wrapper\StoreWrapper;

/**
 * Class StoreWrapperTest.
 */
class StoreWrapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test no store.
     *
     * @expectedException \Elcodi\Component\Store\Exception\StoreNotFoundException
     */
    public function testLoadWithoutStore()
    {
        $storeRepository = $this->prophesize('Elcodi\Component\Store\Repository\StoreRepository');

        $storeRepository
            ->findAll()
            ->willReturn([]);

        $storeWrapper = new StoreWrapper($storeRepository->reveal());
        $storeWrapper->get();
    }

    /**
     * Test with store.
     */
    public function testLoadWithStore()
    {
        $storeRepository = $this->prophesize('Elcodi\Component\Store\Repository\StoreRepository');
        $store = $this
            ->prophesize('Elcodi\Component\Store\Entity\Interfaces\StoreInterface')
            ->reveal();

        $storeRepository
            ->findAll()
            ->willReturn([
                $store,
            ])
            ->shouldBeCalledTimes(1);

        $storeWrapper = new StoreWrapper($storeRepository->reveal());
        $storeResult = $storeWrapper->get();

        $this->assertSame(
            $store,
            $storeResult
        );

        $storeResultAgain = $storeWrapper->get();

        $this->assertSame(
            $store,
            $storeResultAgain
        );
    }
}
