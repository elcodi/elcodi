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

namespace Elcodi\ReferralProgramBundle\EventListener;

use Elcodi\CartCouponBundle\Services\OrderCouponManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\CartBundle\Event\OrderPostCreatedEvent;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\ReferralProgramBundle\ElcodiReferralProgramBundle;
use Elcodi\ReferralProgramBundle\ElcodiReferralProgramRuleTypes;
use Elcodi\ReferralProgramBundle\Services\ReferralCouponManager;
use Elcodi\UserBundle\Event\CustomerRegisterEvent;

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
    )
    {
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
        /**
         * @var Cookie $cookie
         */
        $cookie = $this->request->cookies->get(ElcodiReferralProgramBundle::REFERRAL_PROGRAM_COOKIE_NAME);

        if (!empty($cookie)) {

            $customer = $event->getCustomer();
            $this
                ->referralCouponManager
                ->checkCouponAssignment($customer, $cookie, ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER);
        }
    }

    /**
     * Method triggered when a customer purchases a cart
     *
     * This listener just creates new Coupon if do not exists and if needs to be
     * generated
     *
     * @param OrderPostCreatedEvent $event Event
     */
    public function onCustomerPurchase(OrderPostCreatedEvent $event)
    {
        /**
         * @var Cookie            $cookie
         * @var CustomerInterface $customer
         */
        $customer = $event->getOrder()->getCustomer();

        if ($this->request instanceof Request) {
            $hash = $this->request->cookies->get(ElcodiReferralProgramBundle::REFERRAL_PROGRAM_COOKIE_NAME);

            $this
                ->referralCouponManager
                ->checkCouponAssignment($customer, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
                ->checkCouponsUsed($customer, $this->orderCouponManager->getOrderCoupons($event->getOrder()));
        }
    }
}
