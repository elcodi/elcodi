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

namespace Elcodi\Bundle\TestCommonBundle\Functional;

use Exception;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Container\Traits\ContainerAccessorTrait;

/**
 * Core abstract tests class
 */
abstract class WebTestCase extends BaseWebTestCase
{
    use ContainerAccessorTrait;

    /**
     * @var Application
     *
     * application
     */
    protected static $application;

    /**
     * @var Client
     *
     * Client
     */
    protected $client;

    /**
     * Set up
     */
    public function setUp()
    {
        try {
            static::$kernel = static::createKernel();
            static::$kernel->boot();

            static::$application = new Application(static::$kernel);
            static::$application->setAutoExit(false);
            $this->container = static::$kernel->getContainer();

        } catch (Exception $e) {
die($e->getMessage());
            throw new RuntimeException(
                sprintf('Unable to start the application: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        $this->createSchema();
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        if (static::$application) {
            static::$application->run(new ArrayInput(array(
                'command'          => 'doctrine:database:drop',
                '--no-interaction' => true,
                '--force'          => true,
                '--quiet'          => true,
            )));
        }
    }

    /**
     * Test service can be instanced through container
     */
    public function testServiceLoadFromContainer()
    {
        $serviceCallableNames = $this->getServiceCallableName();

        foreach ($serviceCallableNames as $serviceCallableName) {

            if ($serviceCallableName) {
                $this->assertNotNull(static::$kernel
                        ->getContainer()
                        ->get($serviceCallableName)
                );
            }
        }
    }

    /**
     * Returns the callable name of the service
     *
     * If returns false, avoid service check.
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [];
    }

    /**
     * Returns if service must be retrieved from container
     *
     * @return boolean
     */
    protected function mustTestGetService()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return false;
    }

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Creates schema
     *
     * Only creates schema if loadSchema() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     *
     * @return $this self Object
     */
    protected function createSchema()
    {
        if (!$this->loadSchema()) {
            return $this;
        }

        static::$application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:drop',
            '--no-interaction' => true,
            '--force'          => true,
            '--quiet'          => true,
        )));

        static::$application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:create',
            '--no-interaction' => true,
            '--quiet'          => true,
        )));

        static::$application->run(new ArrayInput(array(
            'command'          => 'doctrine:schema:create',
            '--no-interaction' => true,
            '--quiet'          => true,
        )));

        $this->loadFixtures();

        return $this;
    }

    /**
     * load fixtures method
     *
     * This method is only called if create Schema is set to true
     *
     * Only load fixtures if loadFixtures() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     *
     * @return $this self Object
     */
    protected function loadFixtures()
    {
        if (!is_array($this->loadFixturesBundles())) {
            return $this;
        }

        $bundles = static::$kernel->getBundles();
        $formattedBundles = array_map(function ($bundle) use ($bundles) {
            return $bundles[$bundle]->getPath() . '/DataFixtures/ORM/';
        }, $this->loadFixturesBundles());

        self::$application->run(new ArrayInput(array(
            'command'          => 'doctrine:fixtures:load',
            '--no-interaction' => true,
            '--fixtures'       => $formattedBundles,
            '--quiet'          => true,
        )));

        return $this;
    }

    /**
     * Attempts to guess the kernel location.
     *
     * When the Kernel is located, the file is required.
     *
     * @return string The Kernel class name
     *
     * @throws \RuntimeException
     */
    protected static function getKernelClass()
    {
        $namespaceExploded = explode('\\Tests\\Functional\\', get_called_class(), 2);
        $kernelClass = $namespaceExploded[0] . '\\Tests\\Functional\\app\\AppKernel';

        return $kernelClass;
    }

    /**
     * Creates a Kernel.
     *
     * Available options:
     *
     *  * environment
     *  * debug
     *
     * @param array $options An array of options
     *
     * @return KernelInterface A KernelInterface instance
     */
    protected static function createKernel(array $options = array())
    {
        static::$class = static::getKernelClass();

        $namespaceExploded = explode('\\Tests\\Functional\\', get_called_class(), 2);
        $bundleName = explode('Elcodi\\', $namespaceExploded[0], 2)[1];
        $bundleName = str_replace('\\', '_', $bundleName);

        return new static::$class($bundleName . 'Test', true);
    }
}
