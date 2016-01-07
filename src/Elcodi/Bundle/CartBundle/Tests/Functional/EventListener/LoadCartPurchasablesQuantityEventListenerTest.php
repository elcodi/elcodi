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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\CartBundle\Tests\Functional\EventListener\Abstracts\AbstractCartEventListenerTest;

/**
 * Class LoadCartPurchasablesQuantityEventListenerTest.
 */
class LoadCartPurchasablesQuantityEventListenerTest extends AbstractCartEventListenerTest
{
    /**
     * Test loadCartTotalAmount.
     */
    public function testLoadCartAmounts()
    {
        $cart = $this->getLoadedCart(2);
        $this->assertEquals(3000, $cart
            ->getPurchasableAmount()
            ->getAmount()
        );

        $this->assertEquals(3000, $cart
            ->getAmount()
            ->getAmount()
        );
    }
}
