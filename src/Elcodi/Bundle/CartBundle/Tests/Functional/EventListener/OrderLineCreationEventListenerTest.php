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

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Transformer\CartOrderTransformer;

/**
 * Class OrderLineCreationEventListenerTest.
 */
class OrderLineCreationEventListenerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
        ];
    }

    /**
     * Test update stock positive.
     *
     * @dataProvider dataUpdateStock
     */
    public function testUpdateStock(
        $stock,
        $quantity,
        $finalStock
    ) {
        $this->reloadScenario();

        /**
         * @var CartOrderTransformer $cartOrderTransformer
         */
        $cartOrderTransformer = $this
            ->get('elcodi.transformer.cart_order');

        /**
         * @var CartInterface     $cart
         * @var CartLineInterface $cartLine
         */
        $cart = $this->find('cart', 2);
        $cartLine = $cart
            ->getCartLines()
            ->first()
            ->setQuantity($quantity);

        $this->flush($cartLine);

        $purchasable = $cartLine
            ->getPurchasable()
            ->setStock($stock);

        $this->flush($purchasable);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $cartOrderTransformer->createOrderFromCart($cart);
        $this->assertEquals($finalStock, $purchasable->getStock());
    }

    /**
     * Data for testUpdateStock.
     */
    public function dataUpdateStock()
    {
        return [
            [5, 2, 3],
            [5, 5, 0],
            [5, 6, 0],
            [null, 1, null],
            [null, 10, null],
            [null, 100, null],
        ];
    }
}
