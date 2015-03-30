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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Services;

use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Repository\ProductRepository;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingPriceRangeInterface;
use Elcodi\Component\Shipping\Repository\ShippingRangeRepository;

/**
 * Class WizardStatus
 */
class WizardStatus
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * @var ProductRepository
     *
     * Product repository
     */
    protected $productRepository;

    /**
     * @var ShippingRangeRepository
     *
     * Shipping range repository
     */
    protected $shippingRangeRepository;

    /**
     * Builds a new WizardStepChecker
     *
     * @param ConfigurationManager    $configurationManager    Configuration
     *                                                         manager
     * @param ProductRepository       $productRepository       Product
     *                                                         repository
     * @param ShippingRangeRepository $shippingRangeRepository A shipping range
     *                                                         repository
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        ProductRepository $productRepository,
        ShippingRangeRepository $shippingRangeRepository
    ) {
        $this->configurationManager    = $configurationManager;
        $this->productRepository       = $productRepository;
        $this->shippingRangeRepository = $shippingRangeRepository;
    }

    /**
     * Checks if the wizard has already been finished
     *
     * @return boolean
     */
    public function isWizardFinished()
    {
        return is_null($this->getNextStep());
    }

    /**
     * Get the next step.
     *
     * @return integer|null The next step, null if the wizard is finished.
     */
    public function getNextStep()
    {
        $stepsFinishedStatus = $this->getStepsFinishStatus();

        foreach ($stepsFinishedStatus as $step => $stepIsFinished) {
            if (!$stepIsFinished) {
                return (int) $step;
            }
        }

        return;
    }

    /**
     * Checks if the received step is finished.
     *
     * @param integer $stepNumber A step number.
     *
     * @return boolean If the step is finished
     */
    public function isStepFinished($stepNumber)
    {
        switch ($stepNumber) {
            case 1:
                return $this->isThereAnyProduct();
            case 2:
                return $this->isAddressFulfilled();
            case 3:
                return $this->isPaymentFulfilled();
            case 4:
                return $this->isThereAnyShippingRange();
            default:
                return true;
        }
    }

    /**
     * Gets the finish status for all the steps
     *
     * @return boolean[]
     */
    public function getStepsFinishStatus()
    {
        return [
            1 => $this->isStepFinished(1),
            2 => $this->isStepFinished(2),
            3 => $this->isStepFinished(3),
            4 => $this->isStepFinished(4),
        ];
    }

    /**
     * Checks if the address has been fulfilled.
     *
     * @return boolean
     */
    protected function isAddressFulfilled()
    {
        $storeAddress = $this
            ->configurationManager
            ->get('store.address');

        return !empty($storeAddress);
    }

    /**
     * Checks if there is any product on the store.
     *
     * @return boolean
     */
    protected function isThereAnyProduct()
    {
        $enabledProduct = $this
            ->productRepository
            ->findOneBy([
                'enabled' => true,
            ]);

        return ($enabledProduct instanceof ProductInterface);
    }

    /**
     * Checks if the payment has been fulfilled
     *
     * @return boolean
     */
    protected function isPaymentFulfilled()
    {
        $paymillPrivateKey       = $this
            ->configurationManager
            ->get('store.paymill_private_key');
        $paymillPublicKey = $this
            ->configurationManager
            ->get('store.paymill_public_key');
        $paypalCheckoutRecipient = $this
            ->configurationManager
            ->get('store.paypal_web_checkout_recipient');

        return
            '' !== $paymillPrivateKey &&
            '' !== $paymillPublicKey &&
            '' !== $paypalCheckoutRecipient;
    }

    /**
     * Checks if any shipping range has been added to the store.
     *
     * @return boolean
     */
    protected function isThereAnyShippingRange()
    {
        $shippingRange = $this
            ->shippingRangeRepository
            ->findOneBy([]);

        return ($shippingRange instanceof ShippingPriceRangeInterface);
    }
}
