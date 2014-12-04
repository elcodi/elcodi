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

namespace Elcodi\Bundle\ConfigurationBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Configuration\Services\ConfigurationManager;

/**
 * Class ConfigurationManagerTest
 */
class ConfigurationManagerTest extends WebTestCase
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.configuration.service.configuration_manager',
            'elcodi.configuration_manager'
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiConfigurationBundle',
        );
    }

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->configurationManager = $this->get('elcodi.configuration_manager');
    }

}
