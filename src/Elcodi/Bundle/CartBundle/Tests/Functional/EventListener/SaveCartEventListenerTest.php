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
 * Class SaveCartEventListenerTest.
 */
class SaveCartEventListenerTest extends AbstractCartEventListenerTest
{
    /**
     * Test loadCartPurchasablesQuantities.
     */
    public function testSaveCart()
    {
        $cart = $this
            ->getFactory('cart')
            ->create()
            ->setCustomer($this->find('customer', 1));

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $cart,
                $this->find('product', 1),
                1
            );

        $this->assertNotNull($cart->getId());
    }
}
