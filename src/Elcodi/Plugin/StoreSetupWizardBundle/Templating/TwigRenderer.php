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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Templating;

use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;

/**
 * Class TwigRenderer
 */
class TwigRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var WizardStatus
     *
     * A WizardStatus
     */
    protected $wizardStatus;

    /**
     * @var RequestStack
     *
     * A request stack
     */
    protected $requestStack;

    /**
     * Builds a new class
     *
     * @param WizardStatus $wizardStatus The Wizard status
     * @param RequestStack $requestStack A request stack
     */
    public function __construct(
        WizardStatus $wizardStatus,
        RequestStack $requestStack
    ) {
        $this->wizardStatus = $wizardStatus;
        $this->requestStack = $requestStack;
    }

    /**
     * Set plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders the mini wizard bar
     *
     * @param EventInterface $event The event
     */
    public function renderMiniWizard(EventInterface $event)
    {
        if (
            $this->plugin->isEnabled() &&
            $this->isVisible()
        ) {
            $stepsFinished = $this
                ->wizardStatus
                ->getStepsFinishStatus();

            $activeStep = $this
                ->wizardStatus
                ->getNextStep();

            $this->appendTemplate(
                '@ElcodiStoreSetupWizard/Wizard/wizard.html.twig',
                $event,
                [
                    'stepsFinished' => $stepsFinished,
                    'activeStep'    => $activeStep,
                    'isMiniWizard'  => true,
                ]
            );
        }
    }

    /**
     * Checks if the wizard is visible for this request.
     *
     * @return bool If visible
     */
    protected function isVisible()
    {
        $masterRequest = $this
            ->requestStack
            ->getMasterRequest();

        if ($masterRequest->query->get('modal', false)) {
            return false;
        }

        $route = $masterRequest
            ->attributes
            ->get('_route');

        if (in_array(
            $route,
            [
                'admin_product_new',
                'admin_address_new',
                'admin_address_edit',
                'admin_payment_configuration_list',
                'admin_carrier_new',
            ]
        )) {
            return false;
        }

        return true;
    }
}
