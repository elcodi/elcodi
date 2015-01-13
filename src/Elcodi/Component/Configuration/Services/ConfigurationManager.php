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

namespace Elcodi\Component\Configuration\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Elcodi\Component\Configuration\ElcodiConfigurationTypes;
use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
use Elcodi\Component\Configuration\Exception\ConfigurationParameterNotFoundException;
use Elcodi\Component\Configuration\Factory\ConfigurationFactory;
use Elcodi\Component\Configuration\Repository\ConfigurationRepository;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;

/**
 * Class ConfigurationManager
 */
class ConfigurationManager extends AbstractCacheWrapper
{
    /**
     * @var ObjectManager
     *
     * Configuration Object manager
     */
    protected $configurationObjectManager;

    /**
     * @var ConfigurationRepository
     *
     * Configuration repository
     */
    protected $configurationRepository;

    /**
     * @var ConfigurationFactory
     *
     * Configuration factory
     */
    protected $configurationFactory;

    /**
     * @var ParameterBagInterface
     *
     * Parameter bag
     */
    protected $parameterBag;

    /**
     * @var array
     *
     * Configuration elements
     */
    protected $configurationElements;

    /**
     * @param ObjectManager           $configurationObjectManager Configuration Object manager
     * @param ConfigurationRepository $configurationRepository    Configuration repository
     * @param ConfigurationFactory    $configurationFactory       Configuration factory
     * @param ParameterBagInterface   $parameterBag               Parameter bag
     * @param array                   $configurationElements      Configuration elements
     */
    public function __construct(
        ObjectManager $configurationObjectManager,
        ConfigurationRepository $configurationRepository,
        ConfigurationFactory $configurationFactory,
        ParameterBagInterface $parameterBag,
        array $configurationElements
    )
    {
        $this->configurationObjectManager = $configurationObjectManager;
        $this->configurationRepository = $configurationRepository;
        $this->configurationFactory = $configurationFactory;
        $this->parameterBag = $parameterBag;
        $this->configurationElements = $configurationElements;
    }

    /**
     * Set a parameter
     *
     * @param string $parameterIdentifier Parameter identifier
     * @param mixed  $parameterValue      Parameter value
     *
     * @return ConfigurationInterface|null Object saved
     */
    public function setParameter(
        $parameterIdentifier,
        $parameterValue = null
    )
    {
        $this->saveParameter(
            $parameterIdentifier,
            $parameterValue,
            false
        );

        return $this;
    }

    /**
     * Load a parameter given the key and the namespace
     *
     * @param string $parameterIdentifier Parameter identifier
     *
     * @return null|string|boolean Configuration parameter value
     *
     * @throws ConfigurationParameterNotFoundException Configuration not found
     */
    public function getParameter($parameterIdentifier)
    {
        $valueIsCached = $this
            ->cache
            ->contains($parameterIdentifier);

        /**
         * The value is cached, so we can securely return its value
         */
        if (false !== $valueIsCached) {
            return $valueIsCached = $this
                ->cache
                ->fetch($parameterIdentifier);
        }

        /**
         * Otherwise we must generate it
         */
        $configuration = $this->saveParameter(
            $parameterIdentifier,
            null,
            true
        );

        if (!($configuration instanceof ConfigurationInterface)) {

            throw new ConfigurationParameterNotFoundException();
        }

        return $configuration->getValue();
    }

    /**
     * Saves a parameter
     *
     * @param string  $parameterIdentifier Parameter identifier
     * @param mixed   $parameterValue      Parameter value
     * @param boolean $onlyDefined         Only create defined elements
     *
     * @return ConfigurationInterface|null Object saved
     */
    protected function saveParameter(
        $parameterIdentifier,
        $parameterValue = null,
        $onlyDefined = true
    )
    {
        list($parameterNamespace, $parameterKey) = $this->splitConfigurationKey($parameterIdentifier);

        $configurationEntity = $this
            ->configurationRepository
            ->find([
                'namespace' => $parameterNamespace,
                'key'       => $parameterKey
            ]);

        /**
         * We found an existing configuration parameter. We update it and return
         * its value
         */
        if ($configurationEntity instanceof ConfigurationInterface) {

            if (!is_null($parameterValue)) {

                $configurationEntity->setValue($parameterValue);
            }

            $this->flushConfiguration(
                $configurationEntity,
                $parameterIdentifier
            );

            return $configurationEntity;
        }

        /**
         * Value is not found on database. We can just check if the value is
         * defined in the configuration elements, and we can generate new entry
         * for our database
         */
        if (
            $onlyDefined &&
            !$this->configurationElements[$parameterIdentifier]
        ) {
            return null;
        }

        /**
         * Let's create the new configuration instance and flush it
         */
        $parameterReference = $this->configurationElements[$parameterIdentifier]['reference'];
        $configurationValue = $parameterValue
            ?: $this->parameterBag->get($parameterReference);

        $configurationEntity = $this
            ->configurationFactory
            ->create()
            ->setKey($parameterKey)
            ->setNamespace($parameterNamespace)
            ->setName($this->configurationElements[$parameterIdentifier]['name'])
            ->setType($this->configurationElements[$parameterIdentifier]['type'])
            ->setValue($configurationValue);

        $this->flushConfiguration(
            $configurationEntity,
            $parameterIdentifier
        );

        return $configurationEntity;
    }

    /**
     * Compose key for a configuration
     *
     * @param string $parameterIdentifier Parameter identifier
     *
     * @return string[] Identifier splitted
     */
    protected function splitConfigurationKey($parameterIdentifier)
    {
        $parameterIdentifier = explode('.', $parameterIdentifier, 2);

        if (count($parameterIdentifier) === 1) {

            array_unshift($parameterIdentifier, '');
        }

        return $parameterIdentifier;
    }

    /**
     * Flush configuration entity
     *
     * @param ConfigurationInterface $configuration           Configuration
     * @param string                 $configurationIdentifier Configuration identifier
     *
     * @return $this Self object
     */
    protected function flushConfiguration(
        ConfigurationInterface $configuration,
        $configurationIdentifier
    )
    {
        $configurationValue = $this
            ->normalizeValue($configuration)
            ->getValue();

        $this
            ->configurationObjectManager
            ->persist($configuration);

        $this
            ->configurationObjectManager
            ->flush($configuration);

        $this
            ->cache
            ->save($configurationIdentifier, $configurationValue);
    }

    /**
     * Normalizes configuration value
     *
     * @param ConfigurationInterface $configuration Configuration
     *
     * @return ConfigurationInterface Configuration
     */
    protected function normalizeValue(ConfigurationInterface $configuration)
    {
        if ($configuration->getType() === ElcodiConfigurationTypes::TYPE_BOOLEAN) {

            $configuration->setValue((boolean) $configuration->getValue());
        }

        return $configuration;
    }
}
