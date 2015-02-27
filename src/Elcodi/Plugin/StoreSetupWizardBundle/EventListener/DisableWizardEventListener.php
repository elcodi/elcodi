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

use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Services\PluginManager;
use Elcodi\Plugin\StoreSetupWizardBundle\Services\WizardStatus;

/**
 * Class DisableWizardEventListener
 */
class DisableWizardEventListener
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
    protected $pluginManager;

    /**
     * @var ConfigurationManager
     *
     * A configuration manager.
     */
    protected $configurationManager;

    /**
     * Builds a new class
     *
     * @param WizardStatus         $wizardStatus         A wizard status service
     * @param PluginManager        $pluginManager        A plugin manager
     * @param ConfigurationManager $configurationManager A configuration manager
     */
    public function __construct(
        WizardStatus $wizardStatus,
        PluginManager $pluginManager,
        ConfigurationManager $configurationManager
    ) {
        $this->wizardStatus         = $wizardStatus;
        $this->pluginManager        = $pluginManager;
        $this->configurationManager = $configurationManager;
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
        $storeEnabled =
            'on' == $this
                ->configurationManager
                ->get('store.enabled');

        if (
            $this->plugin->isEnabled() &&
            $this->wizardStatus->isWizardFinished() &&
            $storeEnabled
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
