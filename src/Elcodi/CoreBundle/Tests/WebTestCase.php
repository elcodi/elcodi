<?php

/**
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

namespace Elcodi\CoreBundle\Tests;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Core abstract tests class
 *
 * @backupGlobals disabled
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
     * @var boolean
     *
     * Deployment quietness
     */
    protected $quiet = false;

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
        $serviceCallableNames = $this->getServiceCallableName();

        if (!is_array($serviceCallableNames)) {

            $serviceCallableNames = array($serviceCallableNames);
        }

        foreach ($serviceCallableNames as $serviceCallableName) {

            static::$kernel->getContainer()->get($serviceCallableName);
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
     * @return BaseWebTestCase self Object
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
     * @return BaseWebTestCase self Object
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
     * Clears manager
     *
     * @return BaseWebTestCase self Object
     */
    protected function clear()
    {
        $this->manager->clear();

        return $this;
    }

    /**
     * Get entity repository given its class parameter
     *
     * i.e. elcodi.core.core.entity.language.class
     *
     * @param string $entityClassParameter Entity namespace parameter
     *
     * @return EntityRepository Repository
     */
    public function getRepository($entityClassParameter)
    {
        return $this
            ->container
            ->get('elcodi.repository_provider')
            ->getRepositoryByEntityParameter($entityClassParameter);
    }

    /**
     * Get manager given its class parameter
     *
     * i.e. elcodi.core.core.entity.language.class
     *
     * @param string $entityClassParameter Entity namespace parameter
     *
     * @return ObjectManager Manager
     */
    public function getManager($entityClassParameter)
    {
        return $this
            ->container
            ->get('elcodi.manager_provider')
            ->getManagerByEntityParameter($entityClassParameter);
    }
}
