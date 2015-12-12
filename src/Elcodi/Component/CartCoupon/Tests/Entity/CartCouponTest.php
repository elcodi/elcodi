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

namespace Elcodi\Component\CartCoupon\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\CartCoupon\Entity\CartCoupon;
use Elcodi\Component\Core\Tests\Entity\Traits;

class CartCouponTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    /**
     * @var CartCoupon
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CartCoupon();
    }

    public function testCart()
    {
        $cart = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $setterOutput = $this->object->setCart($cart);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCart();
        $this->assertSame($cart, $getterOutput);
    }

    public function testCoupon()
    {
        $coupon = $this->getMock('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $setterOutput = $this->object->setCoupon($coupon);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCoupon();
        $this->assertSame($coupon, $getterOutput);
    }
}
