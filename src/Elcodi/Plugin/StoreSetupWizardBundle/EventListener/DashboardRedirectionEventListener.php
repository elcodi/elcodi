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

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Elcodi\Component\Plugin\Entity\Plugin;

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
     * @var Router
     *
     * Router
     */
    protected $router;

    /**
     * Builds a new class
     *
     * @param Router $router A router
     */
    public function __construct(
        Router $router
    ) {
        $this->router = $router;
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
        if ($this->plugin->isEnabled()) {
            $request      = $event->getRequest();
            $currentRoute = $this->getCurrentRequestRoute($request);

            if ('admin_homepage' == $currentRoute) {
                $event->setResponse(
                    new RedirectResponse(
                        $this->router->generate('admin_store_setup_wizard')
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
