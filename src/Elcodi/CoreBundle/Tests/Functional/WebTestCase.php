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

namespace Elcodi\CoreBundle\Tests\Functional;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

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
     * @var ContainerInterface
     *
     * Container
     */
    private $container;

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
        try {
        static::$kernel->boot();
    } catch (\Exception $e) {

        echo $e->getMessage();
}
        static::$application = new Application(static::$kernel);
        static::$application->setAutoExit(false);
        $this->container = static::$kernel->getContainer();
        $this->router = $this->get('router');

        $this->createSchema();
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        static::$application->run(new ArrayInput(array(
            'command'          => 'doctrine:database:drop',
            '--no-interaction' => true,
            '--force'          => true,
            '--quiet'          => true,
        )));
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
     * Get manager given its its entity name
     *
     * @param string $entityName Entity name
     *
     * @return ObjectManager Manager
     */
    public function getObjectManager($entityName)
    {
        return $this
            ->container
            ->get('elcodi.object_manager.' . $entityName);
    }

    /**
     * Get entity repository given its entity name
     *
     * @param string $entityName Entity name
     *
     * @return EntityRepository Repository
     */
    public function getRepository($entityName)
    {
        return $this
            ->container
            ->get('elcodi.repository.' . $entityName);
    }

    /**
     * Get factory given its its entity name
     *
     * @param string $entityName Entity name
     *
     * @return AbstractFactory Factory
     */
    public function getFactory($entityName)
    {
        return $this
            ->container
            ->get('elcodi.factory.' . $entityName);
    }

    /**
     * Get container service
     *
     * @param string $serviceName Container service name
     *
     * @return object The associated service
     */
    public function get($serviceName)
    {
        return $this
            ->container
            ->get($serviceName);
    }

    /**
     * Get container parameter
     *
     * @param string $parameterName Container parameter name
     *
     * @return object The required parameter value
     */
    public function getParameter($parameterName)
    {
        return $this
            ->container
            ->getParameter($parameterName);
    }

    /**
     * Get the entity instance with id $id
     *
     * @param string  $entityName Entity name
     * @param integer $id         Instance if
     *
     * @return AbstractEntity Entity
     */
    public function find($entityName, $id)
    {
        return $this
            ->getRepository($entityName)
            ->find($id);
    }

    /**
     * Get all entity instances
     *
     * @param string $entityName Entity name
     *
     * @return Collection Entity Collection
     */
    public function findAll($entityName)
    {
        return $this
            ->getRepository($entityName)
            ->findAll();
    }

    /**
     * Save an entity. To ensure the method is simple, the entity will be
     * persisted always
     *
     * @param AbstractEntity $entity Entity
     *
     * @return WebTestCase self Object
     */
    public function flush($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this
            ->get('elcodi.manager_provider')
            ->getManagerByEntityNamespace(get_class($entity));

        $objectManager->persist($entity);
        $objectManager->flush($entity);

        return $this;
    }

    /**
     * Remove an entity from ORM map.
     *
     * @param AbstractEntity $entity Entity
     *
     * @return WebTestCase self Object
     */
    public function clear($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this
            ->get('elcodi.manager_provider')
            ->getManagerByEntityNamespace(get_class($entity));

        $objectManager->clear($entity);

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

        return new static::$class('test', true);
    }
}
