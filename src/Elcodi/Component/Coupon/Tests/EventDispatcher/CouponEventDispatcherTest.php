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

namespace Elcodi\Component\Coupon\Tests\EventDispatcher;

use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Coupon\ElcodiCouponEvents;
use Elcodi\Component\Coupon\EventDispatcher\CouponEventDispatcher;

class CouponEventDispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CouponEventDispatcher
     */
    protected $object;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->object = new CouponEventDispatcher($this->eventDispatcher);
    }

    public function testNotifyCouponUsage()
    {
        $coupon = $this->getMock('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface');

        $this->eventDispatcher
            ->method('dispatch')
            ->will($this->returnCallback(function ($a1, $a2) {
                $this->assertSame(ElcodiCouponEvents::COUPON_USED, $a1);
                $this->assertInstanceOf('Elcodi\Component\Coupon\Event\CouponOnUsedEvent', $a2);
            }))
        ;

        $output = $this->object->notifyCouponUsage($coupon);
        $this->assertSame($this->object, $output);
    }
}
