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

namespace Elcodi\Bundle\CouponBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Factory\CouponFactory;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class CouponData
 */
class CouponData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        /**
         * @var CurrencyInterface $currency
         * @var CouponFactory     $couponFactory
         */
        $couponFactory = $this->container->get('elcodi.core.coupon.factory.coupon');
        $currency = $this->getReference('currency-dollar');

        /**
         * Coupon with 12% of discount
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it 5 times in all life
         *
         * Only 100 available
         *
         * @var CouponInterface $couponPercent
         */
        $couponPercent = $couponFactory->create();
        $couponPercent
            ->setCode('percent')
            ->setName('10 percent discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(12)
            ->setCount(100)
            ->setValidFrom(new DateTime())
            ->setValidTo(new DateTime('next month'));
        $manager->persist($couponPercent);
        $this->addReference('coupon-percent', $couponPercent);

        /**
         * Coupon with 5 USD of discount.
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it n times in all life
         *
         * Only 20 available
         *
         * Prices are stored in cents. @see \Elcodi\Component\Currency\Entity\Money
         *
         * @var CouponInterface $couponAmount
         */
        $couponAmount = $couponFactory->create();
        $couponAmount
            ->setCode('amount')
            ->setName('5 USD discount')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(500, $currency))
            ->setCount(20)
            ->setValidFrom(new DateTime());
        $manager->persist($couponAmount);
        $this->addReference('coupon-amount', $couponAmount);

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
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
        ];
    }
}
