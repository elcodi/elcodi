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
 */

namespace Elcodi\Bundle\BambooBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\BambooBundle\Interfaces\TemplateBundleInterface;
use Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class TemplateLoader
 */
class TemplateLoader
{
    /**
     * @var array
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
    )
    {
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

            if ($bundle instanceof TemplateBundleInterface) {

                $bundleName = $bundle->getName();
                $templates->set($bundleName, [
                    'bundle' => $bundleName,
                    'name'   => $bundle->getTemplateName()
                ]);
            }
        }

        $templatesArray = $templates->toArray();

        $this
            ->configurationManager
            ->set('store.templates', $templatesArray);

        /**
         * If current template is not available anymore, we assume that the
         * first one is the right one
         */
        if (!isset($templates[$this->configurationManager->get('store.template')])) {

            $this
                ->configurationManager
                ->set(
                    'store.template',
                    $templates->first()['bundle']
                );
        }

        return $templatesArray;
    }
}
