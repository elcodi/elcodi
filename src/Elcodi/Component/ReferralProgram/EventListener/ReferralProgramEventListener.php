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

namespace Elcodi\Component\ReferralProgram\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Cart\Event\OrderOnCreatedEvent;
use Elcodi\Component\CartCoupon\Services\OrderCouponManager;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramCookie;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramRuleTypes;
use Elcodi\Component\ReferralProgram\Services\ReferralCouponManager;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Event\CustomerRegisterEvent;

/**
 * Class ReferralProgramEventListener
 */
class ReferralProgramEventListener
{
    /**
     * @var ReferralCouponManager
     *
     * referralCouponManager
     */
    protected $referralCouponManager;

    /**
     * @var OrderCouponManager
     *
     * Coupon manager
     */
    protected $orderCouponManager;

    /**
     * @var RequestStack
     *
     * Request
     */
    protected $request;

    /**
     * Construct method
     *
     * @param ReferralCouponManager $referralCouponManager Referral program Coupon manager
     * @param OrderCouponManager    $orderCouponManager    Order Coupon Manager
     * @param RequestStack          $requestStack          Request stack
     */
    public function __construct(
        ReferralCouponManager $referralCouponManager,
        OrderCouponManager $orderCouponManager,
        RequestStack $requestStack
    ) {
        $this->referralCouponManager = $referralCouponManager;
        $this->orderCouponManager = $orderCouponManager;
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * Method raised when a new customer is registered
     *
     * This event listener must check if new user's email is contained
     * in any Referral Program row.
     *
     * If is it, respective coupons will be assigned if relative
     * ReferralRule is designed as it
     *
     * @param CustomerRegisterEvent $event Event containing referral data
     */
    public function onCustomerRegister(CustomerRegisterEvent $event)
    {
        $hash = $this->getReferralProgramCookieHash();

        if (!empty($hash)) {
            $customer = $event->getCustomer();
            $this
                ->referralCouponManager
                ->checkCouponAssignment(
                    $customer,
                    $hash,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER
                );
        }
    }

    /**
     * Method triggered when a customer purchases a cart
     *
     * This listener just creates new Coupon if do not exists and if needs to be
     * generated
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function onOrderCreated(OrderOnCreatedEvent $event)
    {
        /**
         * @var Cookie            $cookie
         * @var CustomerInterface $customer
         */
        $customer = $event->getOrder()->getCustomer();

        if ($this->request instanceof Request) {
            $hash = $this->getReferralProgramCookieHash();
            $this
                ->referralCouponManager
                ->checkCouponAssignment(
                    $customer,
                    $hash,
                    ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE
                )
                ->checkCouponsUsed(
                    $customer,
                    $this
                        ->orderCouponManager
                        ->getOrderCoupons($event->getOrder())
                );
        }
    }

    /**
     * Get ReferralProgram hash stored in ReferralProgram cookie
     *
     * @return string Hash
     */
    protected function getReferralProgramCookieHash()
    {
        return $this
            ->request
            ->cookies
            ->get(ElcodiReferralProgramCookie::REFERRAL_PROGRAM_COOKIE_NAME);
    }
}
