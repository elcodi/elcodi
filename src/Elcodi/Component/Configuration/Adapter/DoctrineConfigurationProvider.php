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

namespace Elcodi\Component\Configuration\Adapter;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use Elcodi\Component\Configuration\Adapter\Interfaces\ConfigurationProviderInterface;
use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class DoctrineConfigurationProvider
 */
class DoctrineConfigurationProvider implements ConfigurationProviderInterface
{
    /**
     * @var string
     *
     * Adapter name
     */
    const ADAPTER_NAME = 'doctrine';

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     *
     * Object repository
     */
    protected $repository;

    /**
     * @var AbstractFactory
     *
     * Configuration factory
     */
    protected $configurationFactory;

    /**
     * @param ObjectManager    $manager              Object manager
     * @param ObjectRepository $repository           Object repository
     * @param AbstractFactory  $configurationFactory Configuration factory
     */
    public function __construct(ObjectManager $manager, ObjectRepository $repository, AbstractFactory $configurationFactory)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->configurationFactory = $configurationFactory;
    }

    /**
     * Sets a parameter value
     *
     * @param $parameter string parameter name
     * @param $value     string parameter value
     * @param $namespace string namespace
     *
     * @return $this self Object
     */
    public function setParameter($parameter, $value, $namespace = "")
    {
        $configuration = $this
            ->configurationFactory
            ->create()
            ->setParameter($parameter)
            ->setNamespace($namespace)
            ->setValue($value);

        $this
            ->manager
            ->persist($configuration);

        $this
            ->manager
            ->flush();

        return $this;
    }

    /**
     * Gets a parameter value
     *
     * @param $parameter string parameter name
     * @param $namespace string namespace
     *
     * @return string
     */
    public function getParameter($parameter, $namespace = "")
    {
        /**
         * @var ConfigurationInterface
         */
        $configuration = $this
            ->repository
            ->findOneBy(['parameter' => $parameter, 'namespace' => $namespace]);

        return $configuration ? $configuration->getValue() : null;
    }
}
