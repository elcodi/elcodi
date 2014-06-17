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

namespace Elcodi\CouponBundle\DataFixtures\ORM;

use Elcodi\CouponBundle\ElcodiCouponTypes;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\Factory\CouponFactory;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;

/**
 * Class CouponData
 */
class CouponData extends AbstractFixture implements OrderedFixtureInterface
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
        /**
         * @var CurrencyInterface
         */
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
         * Prices are stored in cents. @see \Elcodi\CurrencyBundle\Entity\Money
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
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
