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

namespace Elcodi\Plugin\StoreSetupWizardBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardRoutes;

/**
 * Class DashboardRedirectionEventListener
 */
class DashboardRedirectionEventListener
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var UrlGeneratorInterface
     *
     * An url generator
     */
    protected $urlGenerator;

    /**
     * @var WizardStatus
     *
     * A wizard status service
     */
    protected $wizardStatus;

    /**
     * @var WizardRoutes
     *
     * The wizard routes service
     */
    protected $wizardRoutes;

    /**
     * Builds a new class
     *
     * @param UrlGeneratorInterface $urlGenerator An url generator
     * @param WizardStatus          $wizardStatus A wizard status service
     * @param WizardRoutes          $wizardRoutes A wizard routes service
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        WizardStatus $wizardStatus,
        WizardRoutes $wizardRoutes
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->wizardStatus = $wizardStatus;
        $this->wizardRoutes = $wizardRoutes;
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
     * Handles the event redirecting to the wizard if the user is visiting the
     * dashboard
     *
     * @param GetResponseEvent $event The response event
     */
    public function handle(GetResponseEvent $event)
    {
        if (
            $this->plugin->isEnabled() &&
            !$this->wizardStatus->isWizardFinished()
        ) {
            $request      = $event->getRequest();
            $currentRoute = $this->getCurrentRequestRoute($request);

            if ('admin_homepage' == $currentRoute) {
                $event->setResponse(
                    new RedirectResponse(
                        $this
                            ->urlGenerator
                            ->generate(
                                $this
                                    ->wizardRoutes
                                    ->getDefaultWizardRoute()
                            )
                    )
                );
            }
        }
    }

    /**
     * Gets the current request route
     *
     * @param Request $request The current request
     *
     * @return string
     */
    protected function getCurrentRequestRoute(Request $request)
    {
        return $request->get('_route');
    }
}
