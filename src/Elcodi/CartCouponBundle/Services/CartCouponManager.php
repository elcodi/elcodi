<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\CartCouponBundle\Event\CouponCartPostApplyEvent;
use Elcodi\CartCouponBundle\Event\CouponCartPreApplyEvent;
use Elcodi\CartCouponBundle\Event\CouponCartPreRemoveEvent;
use Elcodi\CartCouponBundle\ElcodiCartCouponEvents;
use Elcodi\CartCouponBundle\Entity\Interfaces\CartCouponInterface;
use Elcodi\CartCouponBundle\Repository\CartCouponRepository;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartCouponBundle\Factory\CartCouponFactory;
use Elcodi\CartBundle\Services\CartManager;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Exception\CouponAppliedException;
use Elcodi\CouponBundle\Exception\CouponFreeShippingExistsException;
use Elcodi\CouponBundle\Exception\CouponNotAvailableException;
use Elcodi\CouponBundle\Repository\CouponRepository;
use Elcodi\CouponBundle\Services\CouponManager;

/**
 * CartCoupon Manager
 *
 * This class aims to be a bridge between Coupons and Carts.
 * Manages all coupons instances inside Carts
 *
 * Public methods:
 *
 * getCartCoupons(CartInterface)
 * addCouponByCode(CartInterface, $couponCode)
 * removeCouponByCode(CartInterface, $couponCode)
 * addCoupon(CartInterface, CouponInterface)
 * removeCoupon(CartInterface, CouponInterface)
 */
class CartCouponManager
{
    /**
     * @var CouponRepository
     *
     * Coupon Repository
     */
    protected $couponRepository;

    /**
     * @var CartCouponRepository
     *
     * Coupon Repository
     */
    protected $cartCouponRepository;

    /**
     * @var CartCouponFactory
     *
     * CartCoupon Factory
     */
    protected $cartCouponFactory;

    /**
     * @var CartManager
     *
     * Cart manager
     */
    protected $cartManager;

    /**
     * @var CouponManager
     *
     * CouponManager
     */
    protected $couponManager;

    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ObjectManager
     *
     * Manager
     */
    protected $manager;

    /**
     * construct method
     *
     */
    public function __construct(
        CouponRepository $couponRepository,
        CartCouponRepository $cartCouponRepository,
        CartCouponFactory $cartCouponFactory,
        CartManager $cartManager,
        CouponManager $couponManager,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $manager
    )
    {
        $this->couponRepository = $couponRepository;
        $this->cartCouponRepository = $cartCouponRepository;
        $this->cartCouponFactory = $cartCouponFactory;
        $this->cartManager = $cartManager;
        $this->couponManager = $couponManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->manager = $manager;
    }

    /**
     * Get cart coupons.
     *
     * If current cart has not coupons applied, this method will return an empty
     * collection
     *
     * @param CartInterface $cart Cart
     *
     * @return Collection Coupons
     */
    public function getCartCoupons(CartInterface $cart)
    {
        $cartCoupons = $this
            ->cartCouponRepository
            ->findBy(array(
                'cart' => $cart,
            ));

        if (!($cartCoupons instanceof Collection)) {

            $cartCoupons = new ArrayCollection($cartCoupons);
        }

        return $cartCoupons;
    }

    /**
     * Given a coupon code, applies it to cart
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @throws CouponNotAvailableException
     * @throws CouponAppliedException
     * @throws CouponFreeShippingExistsException
     *
     * @return CartCouponManager self Object
     *
     */
    public function addCouponByCode(CartInterface $cart, $couponCode)
    {
        $coupon = $this
            ->couponRepository
            ->findOneBy(array(
                'code'    => $couponCode,
                'enabled' => true,
            ));

        if ($coupon instanceof CouponInterface) {

            $this->addCoupon($cart, $coupon);
        } else {

            throw new CouponNotAvailableException;
        }

        return $this;
    }

    /**
     * Given a coupon code, removes it from cart
     *
     * @param CartInterface $cart       Cart
     * @param string        $couponCode Coupon code
     *
     * @return CartCouponManager self Object
     *
     */
    public function removeCouponByCode(CartInterface $cart, $couponCode)
    {
        $coupon = $this
            ->couponRepository
            ->findOneBy(array(
                'code' => $couponCode,
            ));

        if ($coupon instanceof CouponInterface) {

            $this->removeCoupon($cart, $coupon);
        }

        return $this;
    }

    /**
     * Adds a Coupon to a Cart and recalculates the Cart Totals
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to add
     *
     * @throws CouponAppliedException
     * @throws CouponFreeShippingExistsException
     *
     * @return CartInterface the updated cart
     */
    public function addCoupon(CartInterface $cart, CouponInterface $coupon)
    {
        $cartCoupon = $this
            ->cartCouponRepository
            ->findOneBy(array(
                'cart'   => $cart,
                'coupon' => $coupon,
            ));

        if (!($cartCoupon instanceof CartCouponInterface)) {

            throw new CouponAppliedException;
        }

        /**
         * Coupon is going to be applied into a cart
         */
        $event = new CouponCartPreApplyEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::COUPON_CART_PREAPPLY,
            $event
        );

        /**
         * We create a new instance of CartCoupon.
         * We also persist and flush relation
         */
        $cartCoupon = $this->cartCouponFactory->create();
        $cartCoupon
            ->setCart($cart)
            ->setCoupon($coupon);
        $this->manager->persist($cartCoupon);

        $this->manager->flush($cartCoupon);

        /**
         * Coupon is applied into Cart
         */
        $event = new CouponCartPostApplyEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::COUPON_CART_POSTAPPLY,
            $event
        );

        $this->cartManager->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Removes a Coupon from a Cart, and recalculates Cart Totals
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon The coupon to remove
     *
     * @return CartInterface the updated cart
     */
    public function removeCoupon(CartInterface $cart, CouponInterface $coupon)
    {
        $cartCoupon = $this
            ->cartCouponRepository
            ->findOneBy(array(
                'cart'   => $cart,
                'coupon' => $coupon,
            ));

        if (!($cartCoupon instanceof CartCouponInterface)) {
            return $this;
        }

        /**
         * Coupon is going to be removed from a cart
         */
        $event = new CouponCartPreApplyEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::COUPON_CART_PREREMOVE,
            $event
        );

        $this->manager->remove($cartCoupon);
        $this->manager->flush($cartCoupon);

        /**
         * Coupon removed from a cart
         */
        $event = new CouponCartPreRemoveEvent($cart, $coupon);
        $this->eventDispatcher->dispatch(
            ElcodiCartCouponEvents::COUPON_CART_POSTREMOVE,
            $event
        );

        $this->cartManager->dispatchCartLoadEvents($cart);

        return $this;
    }
}
