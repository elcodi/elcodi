<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\CartBundle\Tests\Functional\Services\Abstracts;

use Doctrine\ORM\UnitOfWork;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CoreBundle\Tests\Functional\WebTestCase;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;

abstract class AbstractCartManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.service.cart_manager',
            'elcodi.cart_manager',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var CartLineInterface
     *
     * Cartline
     */
    protected $cartLine;

    /**
     * @var ProductInterface
     *
     * Product
     */
    protected $purchasable;

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->cart = $this
            ->container
            ->get('elcodi.factory.cart')
            ->create();

        $this->purchasable = $this->createPurchasable();

        $this->cartLine = $this
            ->container
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setPurchasable($this->purchasable)
            ->setProductAmount($this->purchasable->getPrice())
            ->setAmount($this->purchasable->getPrice())
            ->setQuantity(1);

        $this
            ->container
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($this->cart);
    }

    /**
     * Test add line
     *
     * @group cart
     */
    public function testAddLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine);

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getAmount()
        );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getPurchasable()->getPrice()
        );

        $this->assertNotNull($this->cart->getId());
        $this->assertNotNull($this->cartLine->getId());

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getManager('elcodi.core.cart.entity.cart.class')
                ->getUnitOfWork()
                ->getEntityState($this->cart)
        );

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getManager('elcodi.core.cart.entity.cart_line.class')
                ->getUnitOfWork()
                ->getEntityState($this->cartLine)
        );
    }

    /**
     * Test remove line
     *
     * @group cart
     */
    public function testRemoveLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->removeLine($this->cart, $this->cartLine);

        $this->assertRemovedLine();
    }

    /**
     * Test empty lines
     *
     * @group cart
     */
    public function testEmptyLines()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->emptyLines($this->cart);

        $this->assertRemovedLine();
    }

    /**
     * Test edit cart line
     *
     * @group cart
     */
    public function testEditCartLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->editCartLine($this->cartLine, $this->purchasable, 2);

        $this->assertSame(
            $this->cartLine->getPurchasable(),
            $this->purchasable
        );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getAmount()
        );

        $this->assertTrue(
            $this
                ->cart
                ->getAmount()
                ->equals($this
                        ->cart
                        ->getCartLines()
                        ->first()
                        ->getPurchasable()
                        ->getPrice()
                        ->multiply(2)
                )
        );
    }

    /**
     * Test set cartline quantity
     *
     * @skip
     * @dataProvider dataSetCartLineQuantity
     * @group        cart
     */
    public function testSetCartLineQuantity(
        $quantityStart,
        $quantitySetted,
        $quantityEnd
    )
    {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->setCartLineQuantity($this->cartLine, $quantitySetted);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test increase cartline quantity
     *
     * @dataProvider dataIncreaseCartLineQuantity
     * @group        cart
     */
    public function testIncreaseCartLineQuantity(
        $quantityStart,
        $quantityAdded,
        $quantityEnd
    )
    {
        $this->cartLine = $this
            ->container
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setPurchasable($this->purchasable)
            ->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->increaseCartLineQuantity($this->cartLine, $quantityAdded);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test decrease cartline quantity
     *
     * @dataProvider dataDecreaseCartLineQuantity
     * @group        cart
     */
    public function testDecreaseCartLineQuantity(
        $quantityStart,
        $quantityRemoved,
        $quantityEnd
    )
    {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->decreaseCartLineQuantity($this->cartLine, $quantityRemoved);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test add product
     *
     * @dataProvider dataAddProduct
     * @group        cart
     */
    public function testAddProduct(
        $quantitySet,
        $quantityEnd
    )
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addProduct($this->cart, $this->purchasable, $quantitySet);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test result
     */
    public function assertResults($quantity)
    {
        if ($quantity > 0) {

            $cartLine = $this->cart->getCartLines()->first();

            $this->assertEquals(
                $this->cart->getAmount(),
                $cartLine->getAmount()
            );

            $this->assertEquals(
                $this->cart->getAmount()->getAmount(),
                $cartLine->getPurchasable()->getPrice()->getAmount() * $quantity
            );

            $this->assertNotNull($cartLine->getId());
            $this->assertNotNull($this->cart->getId());

            $this->assertEquals(
                UnitOfWork::STATE_MANAGED,
                $this
                    ->getManager('elcodi.core.cart.entity.cart.class')
                    ->getUnitOfWork()
                    ->getEntityState($this->cart)
            );

        } else {
            $this->assertEmpty($this->cart->getCartLines());
            $this->assertEquals(0, $this->cart->getAmount()->getAmount());

            $this->assertEquals(
                UnitOfWork::STATE_NEW,
                $this
                    ->getManager('elcodi.core.cart.entity.cart_line.class')
                    ->getUnitOfWork()
                    ->getEntityState($this->cartLine)
            );
        }
    }

    /**
     * Creates, flushes and returns a Purchasable
     *
     * @return PurchasableInterface
     */
    abstract protected function createPurchasable();

    /**
     * Common asserts for a test that empties lines
     */
    private function assertRemovedLine()
    {
        $this->assertEmpty($this->cart->getCartLines());
        $this->assertNotNull($this->cart->getId());

        $this->assertEquals(
            UnitOfWork::STATE_NEW,
            $this->container
                ->get('elcodi.object_manager.cart_line')
                ->getUnitOfWork()
                ->getEntityState($this->cartLine)
        );
    }
}
