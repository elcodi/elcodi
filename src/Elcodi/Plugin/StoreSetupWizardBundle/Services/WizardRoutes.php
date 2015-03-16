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

/**
 * Class WizardRoutes
 */
class WizardRoutes
{
    /**
     * @var string
     *
     * The wizard default route
     */
    const DEFAULT_WIZARD_ROUTE = 'admin_store_setup_wizard';

    /**
     * @var array
     *
     * The wizard routes by step
     */
    protected $wizardRoutesByStep = [
        1 => 'admin_product_new',
        2 => 'admin_address_edit',
        3 => 'admin_payment_configuration_list',
        4 => 'admin_carrier_new',
    ];

    /**
     * @var WizardStatus
     *
     * The wizardStatus service
     */
    protected $wizardStatus;

    /**
     * Builds a new WizardRoutes class
     *
     * @param WizardStatus $wizardStatus
     */
    public function __construct(
        WizardStatus $wizardStatus
    ) {
        $this->wizardStatus = $wizardStatus;
    }

    /**
     * Get the route for the given step.
     *
     * @param string $step The received step
     *
     * @return string The route
     */
    public function getStepRoute($step)
    {
        return isset($this->wizardRoutesByStep[$step])
            ? $this->wizardRoutesByStep[$step]
            : self::DEFAULT_WIZARD_ROUTE;
    }

    /**
     * Gets the step for the given routes.
     *
     * @param string $route The route to check
     *
     * @return integer|null The step route
     */
    public function getStepByRoute($route)
    {
        $steps = array_flip($this->wizardRoutesByStep);

        return isset($steps[$route])
            ? $steps[$route]
            : null;
    }

    /**
     * Get the next step route.
     *
     * @return string The route
     */
    public function getNextStepRoute()
    {
        $nextStep = $this
            ->wizardStatus
            ->getNextStep();

        return $this
            ->getStepRoute($nextStep);
    }

    /**
     * Checks if the received route is one of the wizards setup pages.
     *
     * @param string $route The received route
     *
     * @return boolean If is part of the wizards setup.
     */
    public function isWizardSetupRoute($route)
    {
        return in_array($route, $this->wizardRoutesByStep);
    }

    /**
     * Gets the default route.
     *
     * @return boolean If is the default route.
     */
    public function getDefaultWizardRoute()
    {
        return self::DEFAULT_WIZARD_ROUTE;
    }

    /**
     * Checks if the wizard is hidden on the given route.
     *
     * @param string $route The route to check.
     *
     * @return boolean If the wizard is hidden.
     */
    public function isWizardHidden($route)
    {
        $hiddenPages = array_merge(
            $this->wizardRoutesByStep,
            [
                'admin_address_new',
            ]
        );

        return in_array($route, $hiddenPages);
    }
}
