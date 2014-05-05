<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Tests;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Core abstract tests class
 */
abstract class WebTestCase extends BaseWebTestCase
{
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
     * @var RouterInterface
     *
     * Router
     */
    protected $router;

    /**
     * @var ObjectManager
     *
     * Entity manager
     */
    protected $manager;

    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected $container;

    /**
     * Set up
     */
    public function setUp()
    {
        gc_collect_cycles();

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        static::$application = new Application(static::$kernel);
        static::$application->setAutoExit(false);

        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $this->container = static::$kernel->getContainer();
        $this->router = $this->container->get('router');
        $this->manager = $this->container->get('doctrine.orm.entity_manager');

        $this
            ->manager
            ->getConnection()
            ->getConfiguration()
            ->setSQLLogger(null);

        $this->createSchema();
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        static::$kernel->shutdown();
        unset($this->client);

        BaseWebTestCase::tearDown();
    }

    /**
     * Test service can be instanced through container
     */
    public function testServiceLoadFromContainer()
    {
        $serviceCallableName = $this->getServiceCallableName();

        if ($serviceCallableName) {

            $this->assertTrue(static::$kernel->getContainer()->has($serviceCallableName));

            if ($this->mustTestGetService() && $this->getServiceCallableName()) {

                static::$kernel->getContainer()->get($this->getServiceCallableName());
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Returns the callable name of the service
     *
     * If returns false, avoid service check.
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return null;
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
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Creates schema
     *
     * Only creates schema if loadSchema() is set to true.
     * All other methods will be loaded if this one is loaded.
     *
     * Otherwise, will return.
     *
     * @return BaseWebTestCase self Object
     */
    protected function createSchema()
    {
        $loadSchema = $this->loadSchema();

        if (!$loadSchema) {

            return $this;
        }
        static::$application->run(new ArrayInput(array('command' => 'doctrine:database:drop', '--no-interaction' => true, '--force' => true, '--quiet' => true)));

        $connection = self::$application->getKernel()->getContainer()->get('doctrine')->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }

        static::$application->run(new ArrayInput(array('command' => 'doctrine:database:create', '--no-interaction' => true, '--quiet' => true)));
        static::$application->run(new ArrayInput(array('command' => 'doctrine:schema:create', '--no-interaction' => true, '--quiet' => true)));

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
     * @return BaseWebTestCase self Object
     */
    protected function loadFixtures()
    {
        if (!is_array($this->loadFixturesBundles())) {

            return $this;
        }

        self::$application->run(new ArrayInput(array('command' => 'doctrine:fixtures:load', '--no-interaction' => true, '--quiet' => true)));

        return $this;
    }

    /**
     * Clears manager
     *
     * @return BaseWebTestCase self Object
     */
    protected function clear()
    {
        $this->manager->clear();

        return $this;
    }
}
