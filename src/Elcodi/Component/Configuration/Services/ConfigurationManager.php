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
use Elcodi\Component\Configuration\Exception\ConfigurationNotEditableException;
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
     * Set a configuration value
     *
     * @param string $configurationIdentifier Configuration identifier
     * @param mixed  $configurationValue      Configuration value
     *
     * @return ConfigurationInterface|null Object saved
     *
     * @throws ConfigurationNotEditableException Configuration not editable
     */
    public function set(
        $configurationIdentifier,
        $configurationValue
    )
    {
        list($configurationNamespace, $configurationKey) = $this->splitConfigurationKey($configurationIdentifier);

        /**
         * We must check if the configuration element is read-only. If it is,
         * we return an exception
         */
        if (
            isset($this->configurationElements[$configurationIdentifier]) &&
            $this->configurationElements[$configurationIdentifier]['read_only'] === true
        ) {

            throw new ConfigurationNotEditableException();
        }

        $configurationLoaded = $this->loadConfiguration(
            $configurationNamespace,
            $configurationKey
        );

        if (!($configurationLoaded instanceof ConfigurationInterface)) {

            $configurationLoaded = $this
                ->createConfigurationInstance(
                    $configurationIdentifier,
                    $configurationNamespace,
                    $configurationKey,
                    $configurationValue
                );
        } else {

            $serializedValue = $this->serializeValue(
                $configurationValue,
                $configurationLoaded->getType()
            );

            $configurationLoaded->setValue($serializedValue);
        }

        $this->flushConfiguration($configurationLoaded);

        $this->flushConfigurationToCache(
            $configurationLoaded,
            $configurationIdentifier
        );

        return $this;
    }

    /**
     * Load a parameter given the key and the namespace
     *
     * @param string $configurationIdentifier Configuration identifier
     *
     * @return null|string|boolean Configuration parameter value
     *
     * @throws ConfigurationParameterNotFoundException Configuration not found
     */
    public function get($configurationIdentifier)
    {
        $valueIsCached = $this
            ->cache
            ->contains($configurationIdentifier);

        /**
         * The value is cached, so we can securely return its value.
         * We must unserialize the value if needed
         */
        if (false !== $valueIsCached) {
            return $this
                ->cache
                ->fetch($configurationIdentifier);
        }

        list($configurationNamespace, $configurationKey) = $this->splitConfigurationKey($configurationIdentifier);

        $configurationLoaded = $this->loadConfiguration(
            $configurationNamespace,
            $configurationKey
        );

        if (!($configurationLoaded instanceof ConfigurationInterface)) {

            $parameterReference = $this->configurationElements[$configurationIdentifier]['reference'];
            $configurationLoaded = $this
                ->createConfigurationInstance(
                    $configurationIdentifier,
                    $configurationNamespace,
                    $configurationKey,
                    $this->parameterBag->get($parameterReference)
                );

            $this->flushConfiguration($configurationLoaded);
        }

        $configurationValueUnserialized = $this->flushConfigurationToCache(
            $configurationLoaded,
            $configurationIdentifier
        );

        return $configurationValueUnserialized;
    }

    /**
     * Loads a configuration
     *
     * @param string $configurationNamespace Configuration namespace
     * @param string $configurationKey       Configuration key
     *
     * @return ConfigurationInterface|null Object saved
     */
    protected function loadConfiguration(
        $configurationNamespace,
        $configurationKey
    )
    {
        $configurationEntity = $this
            ->configurationRepository
            ->find([
                'namespace' => $configurationNamespace,
                'key'       => $configurationKey,
            ]);

        return $configurationEntity;
    }

    /**
     * Flushes a configuration instance
     *
     * @param ConfigurationInterface $configuration Configuration instance
     *
     * @return ConfigurationManager Self object
     */
    protected function flushConfiguration(ConfigurationInterface $configuration)
    {
        $this
            ->configurationObjectManager
            ->persist($configuration);

        $this
            ->configurationObjectManager
            ->flush($configuration);

        return $this;
    }

    /**
     * Creates a new configuration instance and serializes
     *
     * @param string $configurationIdentifier Configuration identifier
     * @param string $configurationNamespace  Configuration namespace
     * @param string $configurationKey        Configuration key
     * @param mixed  $configurationValue      Configuration value
     *
     * @return ConfigurationInterface New Configuration created
     *
     * @throws ConfigurationParameterNotFoundException Configuration not found
     */
    protected function createConfigurationInstance(
        $configurationIdentifier,
        $configurationNamespace,
        $configurationKey,
        $configurationValue
    )
    {
        /**
         * Value is not found on database. We can just check if the value is
         * defined in the configuration elements, and we can generate new entry
         * for our database
         */
        if (!$this->configurationElements[$configurationIdentifier]) {

            throw new ConfigurationParameterNotFoundException();
        }

        $configurationType = $this->configurationElements[$configurationIdentifier]['type'];

        $configurationValue = $this
            ->serializeValue(
                $configurationValue,
                $configurationType
            );

        $configurationEntity = $this
            ->configurationFactory
            ->create()
            ->setKey($configurationKey)
            ->setNamespace($configurationNamespace)
            ->setName($this->configurationElements[$configurationIdentifier]['name'])
            ->setType($configurationType)
            ->setValue($configurationValue);

        return $configurationEntity;
    }

    /**
     * Saves configuration into cache
     *
     * @param ConfigurationInterface $configuration           Configuration
     * @param string                 $configurationIdentifier Configuration identifier
     *
     * @return mixed flushed value
     */
    protected function flushConfigurationToCache(
        ConfigurationInterface $configuration,
        $configurationIdentifier
    )
    {
        $configurationValue = $this->unserializeValue(
            $configuration->getValue(),
            $configuration->getType()
        );

        $this
            ->cache
            ->save(
                $configurationIdentifier,
                $configurationValue
            );

        return $configurationValue;
    }

    /**
     * Split the configuration identifier and return each part
     *
     * @param string $configurationIdentifier Configuration identifier
     *
     * @return string[] Identifier splitted
     */
    protected function splitConfigurationKey($configurationIdentifier)
    {
        $configurationIdentifier = explode('.', $configurationIdentifier, 2);

        if (count($configurationIdentifier) === 1) {

            array_unshift($configurationIdentifier, '');
        }

        return $configurationIdentifier;
    }

    /**
     * Unserialize configuration value
     *
     * @param string $configurationValue Configuration value
     * @param string $configurationType  Configuration type
     *
     * @return mixed Configuration value unserialized
     */
    protected function unserializeValue($configurationValue, $configurationType)
    {
        switch ($configurationType) {

            case ElcodiConfigurationTypes::TYPE_BOOLEAN:
                $configurationValue = (boolean) $configurationValue;
                break;

            case ElcodiConfigurationTypes::TYPE_ARRAY:
                $configurationValue = json_decode($configurationValue, true);
                break;
        }

        return $configurationValue;
    }

    /**
     * Serialize configuration value
     *
     * @param string $configurationValue Configuration value
     * @param string $configurationType  Configuration type
     *
     * @return string Configuration value serialized
     */
    protected function serializeValue($configurationValue, $configurationType)
    {
        switch ($configurationType) {

            case ElcodiConfigurationTypes::TYPE_ARRAY:
                $configurationValue = json_encode($configurationValue);
                break;
        }

        return $configurationValue;
    }
}
