<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\TestCommonBundle\Functional;

use Exception;
use PHPUnit_Framework_TestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Container\Traits\ContainerAccessorTrait;

/**
 * Core abstract tests class.
 */
abstract class WebTestCase extends PHPUnit_Framework_TestCase
{
    use ContainerAccessorTrait;

    /**
     * @var Application
     *
     * application
     */
    protected static $application;

    /**
     * @var KernelInterface
     *
     * kernel
     */
    protected static $kernel;

    /**
     * Reload scenario.
     *
     * @throws RuntimeException unable to start the application
     */
    protected function reloadScenario()
    {
        static::setUpBeforeClass();
    }

    /**
     * Set up before class.
     *
     * @throws RuntimeException unable to start the application
     */
    public static function setUpBeforeClass()
    {
        try {
            static::$kernel = static::createKernel();
            static::$kernel->boot();

            static::$application = new Application(static::$kernel);
            static::$application->setAutoExit(false);
            static::$container = static::$kernel->getContainer();
        } catch (Exception $e) {
            throw new RuntimeException(
                sprintf('Unable to start the application: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        static::createSchema();
    }

    /**
     * Tear down after class.
     *
     * @throws Exception When doRun returns Exception
     */
    public static function tearDownAfterClass()
    {
        if (static::$application) {
            static::$application->run(new ArrayInput([
                'command' => 'doctrine:database:drop',
                '--no-interaction' => true,
                '--force' => true,
                '--quiet' => true,
            ]));
        }
    }

    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return false;
    }

    /**
     * Has fixtures to load.
     *
     * @return static boolean Some fixtures need to be installed
     */
    private static function hasFixturesBundles()
    {
        $fixturesBundles = static::loadFixturesBundles();

        return
            is_array($fixturesBundles) &&
            !empty($fixturesBundles);
    }

    /**
     * Schema must be loaded in all test cases.
     *
     * @return bool Load schema
     */
    protected static function loadSchema()
    {
        return static::hasFixturesBundles();
    }

    /**
     * Creates schema.
     *
     * Only creates schema if loadSchema() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     *
     * @return $this Self object
     */
    protected static function createSchema()
    {
        if (!static::loadSchema()) {
            return;
        }

        static::$application->run(new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--no-interaction' => true,
            '--force' => true,
            '--quiet' => true,
        ]));

        static::$application->run(new ArrayInput([
            'command' => 'doctrine:database:create',
            '--no-interaction' => true,
            '--quiet' => true,
        ]));

        static::$application->run(new ArrayInput([
            'command' => 'doctrine:schema:create',
            '--no-interaction' => true,
            '--quiet' => true,
        ]));

        static::loadFixtures();
    }

    /**
     * load fixtures method.
     *
     * This method is only called if create Schema is set to true
     *
     * Only load fixtures if loadFixtures() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     */
    protected static function loadFixtures()
    {
        if (!static::hasFixturesBundles()) {
            return;
        }

        $bundles = static::$kernel->getBundles();
        $fixturesBundles = static::loadFixturesBundles();

        if (!empty($fixturesBundles)) {
            $formattedBundles = array_map(function ($bundle) use ($bundles) {
                return $bundles[$bundle]->getPath() . '/DataFixtures/ORM/';
            }, $fixturesBundles);

            static::$application->run(new ArrayInput([
                'command' => 'doctrine:fixtures:load',
                '--no-interaction' => true,
                '--fixtures' => $formattedBundles,
                '--quiet' => true,
            ]));
        }

        return;
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
     * @return KernelInterface A KernelInterface instance
     */
    protected static function createKernel()
    {
        $class = static::getKernelClass();

        $namespaceExploded = explode('\\Tests\\Functional\\', get_called_class(), 2);
        $bundleName = explode('Elcodi\\', $namespaceExploded[0], 2)[1];
        $bundleName = str_replace('\\', '_', $bundleName);

        return new $class($bundleName . 'Test', false);
    }

    /**
     * Creates a Client.
     *
     * @param array $server An array of server parameters
     *
     * @return Client A Client instance
     */
    protected static function createClient(array $server = [])
    {
        $client = static::$kernel
            ->getContainer()
            ->get('test.client');

        $client->setServerParameters($server);

        return $client;
    }
}
