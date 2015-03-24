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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Configuration\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;
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
    ) {
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
     * @throws ConfigurationNotEditableException       Configuration parameter is read-only
     * @throws ConfigurationParameterNotFoundException Configuration parameter not found
     */
    public function set(
        $configurationIdentifier,
        $configurationValue
    ) {
        /**
         * Checks if the value is defined in the configuration elements
         */
        if (!array_key_exists($configurationIdentifier, $this->configurationElements)) {
            throw new ConfigurationParameterNotFoundException();
        }

        list($configurationNamespace, $configurationKey) = $this->splitConfigurationKey($configurationIdentifier);

        /**
         * We must check if the configuration element is read-only. If it is,
         * we return an exception
         */
        if (
            is_array($this->configurationElements[$configurationIdentifier]) &&
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
     * Loads a parameter given the format "namespace.key"
     *
     * @param string $configurationIdentifier Configuration identifier
     *
     * @return null|string|boolean Configuration parameter value
     *
     * @throws ConfigurationParameterNotFoundException Configuration parameter not found
     * @throws Exception                               Configuration cannot be resolved
     */
    public function get($configurationIdentifier)
    {
        /**
         * Checks if the value is defined in the configuration elements
         */
        if (!array_key_exists($configurationIdentifier, $this->configurationElements)) {
            throw new ConfigurationParameterNotFoundException();
        }

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
            $configurationElement = $this->configurationElements[$configurationIdentifier];
            $configurationValue = isset($configurationElement['reference'])
                ? $this->parameterBag->get($configurationElement['reference'])
                : $configurationElement['default_value'];

            if (empty($configurationValue) && !$configurationElement['can_be_empty']) {
                $message = $configurationElement['empty_message']
                    ?: 'The configuration element "' . $configurationIdentifier . '" cannot be resolved';

                throw new Exception($message);
            }

            $configurationLoaded = $this
                ->createConfigurationInstance(
                    $configurationIdentifier,
                    $configurationNamespace,
                    $configurationKey,
                    $configurationValue
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
     * Deletes a parameter given the format "namespace.key"
     *
     * @param string $configurationIdentifier
     *
     * @return boolean
     *
     * @throws ConfigurationNotEditableException       Configuration parameter is read-only
     * @throws ConfigurationParameterNotFoundException Configuration parameter not found
     */
    public function delete($configurationIdentifier)
    {
        /**
         * Checks if the value is defined in the configuration elements
         */
        if (!array_key_exists($configurationIdentifier, $this->configurationElements)) {
            throw new ConfigurationParameterNotFoundException();
        }

        /**
         * Checks if the configuration element is read-only.
         */
        if (
            is_array($this->configurationElements[$configurationIdentifier]) &&
            $this->configurationElements[$configurationIdentifier]['read_only'] === true
        ) {
            throw new ConfigurationNotEditableException();
        }

        $valueIsCached = $this
            ->cache
            ->contains($configurationIdentifier);

        /**
         * The value is cached, so first we have to remove it
         */
        if (false !== $valueIsCached) {
            $this
                ->cache
                ->delete($configurationIdentifier);
        }
        list($configurationNamespace, $configurationKey) = $this->splitConfigurationKey($configurationIdentifier);

        $configurationLoaded = $this->loadConfiguration(
            $configurationNamespace,
            $configurationKey
        );

        if ($configurationLoaded instanceof ConfigurationInterface) {
            /*
             * Configuration is found, delete it
             */
            $this->deleteConfiguration($configurationLoaded);

            return true;
        }

        /*
         * Configuration instance was not found
         */
        return false;
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
    ) {
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
     * Deletes a configuration instance
     *
     * @param ConfigurationInterface $configuration Configuration instance
     *
     * @return $this Self object
     */
    protected function deleteConfiguration(ConfigurationInterface $configuration)
    {
        $this
            ->configurationObjectManager
            ->remove($configuration);

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
     * @throws ConfigurationParameterNotFoundException Configuration parameter not found
     */
    protected function createConfigurationInstance(
        $configurationIdentifier,
        $configurationNamespace,
        $configurationKey,
        $configurationValue
    ) {
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
    ) {
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
    public function unserializeValue($configurationValue, $configurationType)
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
