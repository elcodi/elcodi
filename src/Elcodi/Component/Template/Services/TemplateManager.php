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

namespace Elcodi\Component\Template\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException;
use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Template\Interfaces\TemplateInterface;

/**
 * Class TemplateManager
 */
class TemplateManager
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Construct
     *
     * @param KernelInterface      $kernel               Kernel
     * @param ConfigurationManager $configurationManager Configuration Manager
     */
    public function __construct(
        KernelInterface $kernel,
        ConfigurationManager $configurationManager = null
    ) {
        $this->kernel = $kernel;
        $this->configurationManager = $configurationManager;
    }

    /**
     * Load templates
     *
     * @return array Templates found
     *
     * @throws ConfigurationParameterNotFoundException Parameter not found
     * @throws Exception                               ConfigurationBundle not installed
     */
    public function loadTemplates()
    {
        if (!($this->configurationManager instanceof ConfigurationManager)) {
            throw new Exception('You need to install ConfigurationBundle');
        }

        $templates = new ArrayCollection([]);
        $bundles = $this->kernel->getBundles();

        /**
         * @var Bundle $bundle
         */
        foreach ($bundles as $bundle) {
            if ($bundle instanceof TemplateInterface) {
                $bundleName = $bundle->getName();
                $bundleNamespace = $bundle->getNamespace();
                $templates->set($bundleName, [
                    'bundle'    => $bundleName,
                    'namespace' => $bundleNamespace,
                    'name'      => $bundle->getTemplateName(),
                ]);
            }
        }

        $templatesArray = $templates->toArray();

        $this
            ->configurationManager
            ->set('store.templates', $templatesArray);

        return $templatesArray;
    }
}
