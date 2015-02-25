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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Services;

use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Product\Repository\ProductRepository;
use Elcodi\Component\Shipping\Repository\CarrierRepository;

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
     * @var CarrierRepository
     *
     * Carrier repository
     */
    protected $carrierRepository;

    /**
     * Builds a new WizardStepChecker
     *
     * @param ConfigurationManager $configurationManager Configuration
     *                                                   manager
     * @param ProductRepository    $productRepository    Product repository
     * @param CarrierRepository    $carrierRepository    Carrier repository
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        ProductRepository $productRepository,
        CarrierRepository $carrierRepository
    ) {
        $this->configurationManager = $configurationManager;
        $this->productRepository    = $productRepository;
        $this->carrierRepository    = $carrierRepository;
    }

    /**
     * Checks if the wizard has already been finished
     *
     * @return bool
     */
    public function isWizardFinished()
    {
        $stepsFinishedStatus = $this->getStepsFinishStatus();

        foreach ($stepsFinishedStatus as $stepIsFinished) {
            if (!$stepIsFinished) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the finish status for all the steps
     *
     * @return bool[]
     */
    public function getStepsFinishStatus()
    {
        return [
            1 => $this->isAddressFulfilled(),
            2 => $this->isThereAnyProduct(),
            3 => $this->isPaymentFulfilled(),
            4 => $this->isThereAnyCarrier(),
        ];
    }

    /**
     * Checks if the address has been fulfilled.
     *
     * @return bool
     */
    protected function isAddressFulfilled()
    {
        return true;
    }

    /**
     * Checks if there is any product on the store.
     *
     * @return bool
     */
    protected function isThereAnyProduct()
    {
        $products = $this->productRepository->findAll();

        return !empty($products);
    }

    /**
     * Checks if the payment has been fulfilled
     *
     * @return bool
     */
    protected function isPaymentFulfilled()
    {
        return true;
    }

    /**
     * Checks if any carrier has been added to the store.
     *
     * @return bool
     */
    protected function isThereAnyCarrier()
    {
        $carriers = $this->carrierRepository->findAll();

        return !empty($carriers);
    }
}
