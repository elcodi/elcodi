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

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Services\PluginManager;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;

/**
 * Class DashboardRedirectionEventListener
 */
class WizardFinishedEventListener
{
    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var WizardStatus
     *
     * A wizard status service.
     */
    protected $wizardStatus;

    /**
     * @var PluginManager
     *
     * A plugin manager service.
     */
    private $pluginManager;

    /**
     * Builds a new class
     *
     * @param WizardStatus  $wizardStatus  A wizard status service.
     * @param PluginManager $pluginManager A plugin manager
     */
    public function __construct(
        WizardStatus $wizardStatus,
        PluginManager $pluginManager
    ) {
        $this->wizardStatus  = $wizardStatus;
        $this->pluginManager = $pluginManager;
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
     * Checks if the plugin should be disabled
     *
     * @param GetResponseEvent $event The response event
     */
    public function handle(GetResponseEvent $event)
    {
        if (
            $this->plugin->isEnabled() &&
            $this->wizardStatus->isWizardFinished()
        ) {
            $this
                ->pluginManager
                ->updatePlugin(
                    'Elcodi\Plugin\StoreSetupWizardBundle',
                    false
                );
        }
    }
}
