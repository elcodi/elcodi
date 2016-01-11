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

namespace Elcodi\Component\Product\Tests\UnitTest\NameResolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Product\NameResolver\Interfaces\PurchasableNameResolverInterface;
use Elcodi\Component\Product\NameResolver\PackNameResolver;
use Elcodi\Component\Product\NameResolver\PurchasableNameResolver;

/**
 * Class PackNameResolverTest.
 */
class PackNameResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveName(PurchasableNameResolverInterface $resolver)
    {
        $pack = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PackInterface');
        $pack
            ->getName()
            ->willReturn('My Pack');

        $this->assertEquals(
            'My Pack',
            $resolver->resolveName(
                $pack->reveal()
            )
        );
    }

    /**
     * Data for testResolveName.
     */
    public function dataResolveName()
    {
        $packNameResolver = new PackNameResolver();
        $purchasableNameResolver = new PurchasableNameResolver();
        $purchasableNameResolver->addPurchasableNameResolver($packNameResolver);

        return [
            [$purchasableNameResolver],
            [$packNameResolver],
        ];
    }

    /**
     * Test resolve name with bad purchasable instance.
     */
    public function testResolveNameBadInstance()
    {
        $purchasable = $this->prophesize('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $packNameResolver = new PackNameResolver();
        $this->assertFalse(
            $packNameResolver->resolveName(
                $purchasable->reveal()
            )
        );
    }
}
