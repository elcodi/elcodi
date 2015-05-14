<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Bundle\CouponBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
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
         * @var ObjectDirector    $couponDirector
         */
        $couponDirector = $this->getDirector('coupon');
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
        $couponPercent = $couponDirector
            ->create()
            ->setCode('percent')
            ->setName('10 percent discount')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(12)
            ->setCount(100)
            ->setValidFrom(new DateTime())
            ->setValidTo(new DateTime('next month'));

        $couponDirector->save($couponPercent);
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
        $couponAmount = $couponDirector
            ->create()
            ->setCode('amount')
            ->setName('5 USD discount')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(500, $currency))
            ->setCount(20)
            ->setValidFrom(new DateTime());
        $couponDirector->save($couponAmount);
        $this->addReference('coupon-amount', $couponAmount);

        /**
         * Stackable Coupon with 10% of discount
         *
         * Valid from now without expire time
         *
         * Customer only can redeem it 5 times in all life
         *
         * Only 100 available
         *
         * @var CouponInterface $couponPercent
         */
        $stackableCouponPercent = $couponDirector
            ->create()
            ->setCode('stackable-percent')
            ->setName('12 percent discount - stackable')
            ->setType(ElcodiCouponTypes::TYPE_PERCENT)
            ->setDiscount(12)
            ->setCount(100)
            ->setStackable(true)
            ->setValidFrom(new DateTime())
            ->setValidTo(new DateTime('next month'));
        $couponDirector->save($stackableCouponPercent);
        $this->addReference('stackable-coupon-percent', $stackableCouponPercent);

        /**
         * Stackable Coupon with 2 USD of discount.
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
        $stackableCouponAmount = $couponDirector
            ->create()
            ->setCode('stackable-amount')
            ->setName('2 USD discount - stackable')
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice(Money::create(200, $currency))
            ->setCount(20)
            ->setStackable(true)
            ->setValidFrom(new DateTime());
        $couponDirector->save($stackableCouponAmount);
        $this->addReference('stackable-coupon-amount', $stackableCouponAmount);
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
