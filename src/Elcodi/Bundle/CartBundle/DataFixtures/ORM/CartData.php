<?php

/*
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

namespace Elcodi\Bundle\CartBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class CartData
 */
class CartData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Carts
         *
         * @var CartInterface     $emptyCart
         * @var CartInterface     $fullCart
         * @var CustomerInterface $customer
         * @var ProductInterface  $product
         * @var ProductInterface  $productReduced
         * @var CartLineInterface $cartLine1
         * @var CartLineInterface $cartLine2
         */
        $emptyCart = $this
            ->container
            ->get('elcodi.core.cart.factory.cart')
            ->create();

        $customer = $this->getReference('customer-1');
        $product = $this->getReference('product');
        $productReduced = $this->getReference('product-reduced');
        $emptyCart->setCustomer($customer);

        $manager->persist($emptyCart);
        $this->addReference('empty-cart', $emptyCart);

        $fullCart = $this
            ->container
            ->get('elcodi.core.cart.factory.cart')
            ->create();

        $customer = $this->getReference('customer-2');
        $fullCart->setCustomer($customer);

        $cartLine1 = $this
            ->container
            ->get('elcodi.core.cart.factory.cart_line')
            ->create();

        $fullCart->addCartLine($cartLine1);
        $cartLine1
            ->setProduct($product)
            ->setProductAmount($product->getPrice())
            ->setAmount($product->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $cartLine2 = $this
            ->container
            ->get('elcodi.core.cart.factory.cart_line')
            ->create();

        $fullCart->addCartLine($cartLine2);
        $cartLine2
            ->setProduct($productReduced)
            ->setProductAmount($productReduced->getPrice())
            ->setAmount($productReduced->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $manager->persist($fullCart);
        $this->addReference('full-cart', $fullCart);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
            'Elcodi\Bundle\UserBundle\DataFixtures\ORM\CustomerData',
        ];
    }
}
