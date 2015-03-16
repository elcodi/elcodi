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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CartBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Factory\CartFactory;
use Elcodi\Component\Cart\Factory\CartLineFactory;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
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
         * @var CustomerInterface $customer1
         * @var CustomerInterface $customer2
         * @var ProductInterface  $product
         * @var ProductInterface  $productReduced
         * @var CartLineInterface $cartLine1
         * @var CartLineInterface $cartLine2
         * @var CartFactory $cartFactory
         * @var CartLineFactory $cartLineFactory
         * @var AddressInterface $address1
         * @var AddressInterface $address2
         */
        $cartFactory = $this->getFactory('cart');
        $cartLineFactory = $this->getFactory('cart_line');
        $cartObjectManager = $this->getObjectManager('cart');
        $cartLineObjectManager = $this->getObjectManager('cart_line');

        $customer1 = $this->getReference('customer-1');
        $customer2 = $this->getReference('customer-2');
        $product = $this->getReference('product');
        $productReduced = $this->getReference('product-reduced');

        $address1 = $this->getReference('address-sant-celoni');
        $address2 = $this->getReference('address-viladecavalls');

        /**
         * Empty cart
         */
        $emptyCart = $cartFactory
            ->create()
            ->setCustomer($customer1);

        $cartObjectManager->persist($emptyCart);
        $this->addReference('empty-cart', $emptyCart);

        /**
         * Full cart
         */
        $fullCart = $cartFactory
            ->create()
            ->setCustomer($customer2);

        $cartLine1 = $cartLineFactory
            ->create()
            ->setProduct($product)
            ->setProductAmount($product->getPrice())
            ->setAmount($product->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $cartLine2 = $cartLineFactory
            ->create()
            ->setProduct($productReduced)
            ->setProductAmount($productReduced->getPrice())
            ->setAmount($productReduced->getPrice())
            ->setQuantity(2)
            ->setCart($fullCart);

        $fullCart
            ->addCartLine($cartLine1)
            ->addCartLine($cartLine2);

        $fullCart->setBillingAddress($address1);
        $fullCart->setDeliveryAddress($address2);

        $cartObjectManager->persist($fullCart);
        $this->addReference('full-cart', $fullCart);

        $cartObjectManager->flush([
            $emptyCart,
            $fullCart,
        ]);

        $cartLineObjectManager->flush([
            $cartLine1,
            $cartLine2,
        ]);
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\AddressData',
        ];
    }
}
