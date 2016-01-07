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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Services\Abstracts;

use Doctrine\ORM\UnitOfWork;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class AbstractCartManagerTest.
 */
abstract class AbstractCartManagerTest extends WebTestCase
{
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
     * @var PurchasableInterface
     *
     * Purchasable
     */
    protected $purchasable;

    /**
     * Set up.
     */
    public function setUp()
    {
        parent::setUp();

        $this->cart = $this
            ->get('elcodi.factory.cart')
            ->create();

        $this->purchasable = $this->createPurchasable();

        $this->cartLine = $this
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setPurchasable($this->purchasable)
            ->setPurchasableAmount($this->purchasable->getPrice())
            ->setAmount($this->purchasable->getPrice())
            ->setQuantity(1);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($this->cart);
    }

    /**
     * Test add line.
     */
    public function testAddLine()
    {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getAmount()
        );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getPurchasable()->getPrice()
        );

        $this->assertNotNull($this->cart->getId());
        $this->assertNotNull($this->cart->getCartLines()->last()->getId());

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getObjectManager('cart')
                ->getUnitOfWork()
                ->getEntityState($this->cart)
        );

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getObjectManager('cart_line')
                ->getUnitOfWork()
                ->getEntityState($this->cart->getCartLines()->last())
        );
    }

    /**
     * Test remove line.
     */
    public function testRemoveLine()
    {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );

        $line = $this->cart->getCartLines()->last();

        $this
            ->get('elcodi.manager.cart')
            ->removeLine($this->cart, $line);

        $this->assertRemovedLine($line);
    }

    /**
     * Test empty lines.
     */
    public function testEmptyLines()
    {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );

        $line = $this->cart->getCartLines()->last();

        $this
            ->get('elcodi.manager.cart')
            ->emptyLines($this->cart);

        $this->assertRemovedLine($line);
    }

    /**
     * Test edit cart line.
     */
    public function testEditCartLine()
    {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );

        $line = $this->cart->getCartLines()->last();

        $this
            ->get('elcodi.manager.cart')
            ->editCartLine($line, $this->purchasable, 2);

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
     * Test set cartline quantity.
     *
     * @param mixed $quantityStart  Starting quantity
     * @param mixed $quantitySetted Quantity to set
     * @param mixed $quantityEnd    Quantity to check against
     *
     * @dataProvider dataSetCartLineQuantity
     */
    public function testSetCartLineQuantity(
        $quantityStart,
        $quantitySetted,
        $quantityEnd
    ) {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );
        $line = $this->cart->getCartLines()->last();

        $this
            ->get('elcodi.manager.cart')
            ->setCartLineQuantity($line, $quantitySetted);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test increase cartline quantity.
     *
     * @param mixed $quantityStart Starting quantity
     * @param mixed $quantityAdded Quantity to add
     * @param mixed $quantityEnd   Quantity to check against
     *
     * @dataProvider dataIncreaseCartLineQuantity
     */
    public function testIncreaseCartLineQuantity(
        $quantityStart,
        $quantityAdded,
        $quantityEnd
    ) {
        /**
         * @var CartLineInterface $cartLine
         */
        $cartLine = $this
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setPurchasable($this->purchasable)
            ->setQuantity($quantityStart);

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $cartLine->getPurchasable(),
                $cartLine->getQuantity()
            );

        if ($cartLine->getQuantity() == 0) {
            $this->assertFalse($this->cart->getCartLines()->last());

            return;
        }

        $this
            ->get('elcodi.manager.cart')
            ->increaseCartLineQuantity($this->cart->getCartLines()->last(), $quantityAdded);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test decrease cartline quantity.
     *
     * @param mixed $quantityStart   Starting quantity
     * @param mixed $quantityRemoved Quantity to remove
     * @param mixed $quantityEnd     Quantity to check against
     *
     * @dataProvider dataDecreaseCartLineQuantity
     */
    public function testDecreaseCartLineQuantity(
        $quantityStart,
        $quantityRemoved,
        $quantityEnd
    ) {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable(
                $this->cart,
                $this->cartLine->getPurchasable(),
                $this->cartLine->getQuantity()
            );

        $line = $this->cart->getCartLines()->last();

        $this
            ->get('elcodi.manager.cart')
            ->decreaseCartLineQuantity($line, $quantityRemoved);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test add product.
     *
     * @param mixed $quantitySet the quantity to set
     * @param mixed $quantityEnd the quantity to check against
     *
     * @dataProvider dataAddPurchasable
     */
    public function testAddPurchasable(
        $quantitySet,
        $quantityEnd
    ) {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable($this->cart, $this->purchasable, $quantitySet);

        $this->assertResults($quantityEnd);
    }

    /**
     * Test result.
     *
     * @param mixed $quantity the quantity to check against
     */
    public function assertResults($quantity)
    {
        if ($quantity > 0) {
            $cartLine = $this->cart->getCartLines()->first();

            $this->assertEquals(
                $this->cart->getAmount(),
                $cartLine->getAmount()
            );
            $purchasable = $cartLine->getPurchasable();

            $this->assertEquals(
                $this->cart->getAmount()->getAmount(),
                $purchasable->getPrice()->getAmount() * $quantity
            );

            $this->assertNotNull($cartLine->getId());
            $this->assertNotNull($this->cart->getId());

            $this->assertEquals(
                UnitOfWork::STATE_MANAGED,
                $this
                    ->getObjectManager('cart')
                    ->getUnitOfWork()
                    ->getEntityState($this->cart)
            );
        } else {
            $this->assertEmpty($this->cart->getCartLines());
            $this->assertEquals(0, $this->cart->getAmount()->getAmount());

            $this->assertEquals(
                UnitOfWork::STATE_NEW,
                $this
                    ->getObjectManager('cart_line')
                    ->getUnitOfWork()
                    ->getEntityState($this->cartLine)
            );
        }
    }

    /**
     * Creates, flushes and returns a Purchasable.
     *
     * @return PurchasableInterface
     */
    abstract protected function createPurchasable();

    /**
     * Common asserts for a test that empties lines.
     *
     * @param CartLineInterface $line The CartLineInterface needed
     */
    private function assertRemovedLine(CartLineInterface $line)
    {
        $this->assertEmpty($this->cart->getCartLines());
        $this->assertNotNull($this->cart->getId());

        $this->assertEquals(
            UnitOfWork::STATE_NEW,
            $this
                ->get('elcodi.object_manager.cart_line')
                ->getUnitOfWork()
                ->getEntityState($line)
        );
    }
}
