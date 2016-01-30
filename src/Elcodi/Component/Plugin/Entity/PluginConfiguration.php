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

namespace Elcodi\Component\Plugin\Entity;

use RuntimeException;

/**
 * Class PluginConfiguration.
 */
class PluginConfiguration
{
    /**
     * @var array
     *
     * Encoded configuration
     */
    protected $configuration;

    /**
     * Construct.
     *
     * @param array $configuration Configuration
     */
    public function __construct(array $configuration)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * Get configuration.
     *
     * @param array $configuration Configuration
     *
     * @return $this Self object
     */
    protected function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration.
     *
     * @return array $configuration Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get configuration element.
     *
     * @param string $name Configuration element name
     *
     * @return mixed|null Configuration element value
     */
    public function get($name)
    {
        return isset($this->configuration[$name])
            ? $this->configuration[$name]
            : [];
    }

    /**
     * Get fields.
     *
     * @return array Fields
     */
    public function getFields()
    {
        return $this->get('fields');
    }

    /**
     * Get field element.
     *
     * @param string $fieldName Field name
     *
     * @return mixed|null Field element value
     */
    public function getField($fieldName)
    {
        return $this->hasField($fieldName)
            ? $this->configuration['fields'][$fieldName]
            : null;
    }

    /**
     * Has field element.
     *
     * @param string $fieldName Field name
     *
     * @return mixed|null Field element value
     */
    public function hasField($fieldName)
    {
        return isset($this->configuration['fields'][$fieldName]);
    }

    /**
     * Get field element.
     *
     * @param string $fieldName  Field name
     * @param mixed  $fieldValue Field value
     *
     * @return mixed|null Field element value
     */
    public function setFieldValue($fieldName, $fieldValue)
    {
        if (!$this->hasField($fieldName)) {
            throw new RuntimeException('Field "' . $fieldName . '" not found in Plugin Configuration');
        }

        $this->configuration['fields'][$fieldName]['data'] = $fieldValue;

        return $this;
    }

    /**
     * Get field value.
     *
     * @param string $fieldName Field name
     *
     * @return mixed|null Field element value
     */
    public function getFieldValue($fieldName)
    {
        if (!$this->hasField($fieldName)) {
            throw new RuntimeException('Field "' . $fieldName . '" not found in Plugin Configuration');
        }

        return $this->configuration['fields'][$fieldName]['data'];
    }

    /**
     * Merge this configuration instance with a new one, and saves the result in
     * this instance.
     *
     * This method will give priority to its own properties values.
     *
     * @param PluginConfiguration $newPluginConfiguration New plugin configuration
     *
     * @return $this Self object
     */
    public function merge(PluginConfiguration $newPluginConfiguration)
    {
        $newPluginConfiguration = clone $newPluginConfiguration;
        $fields = $newPluginConfiguration->getFields();

        foreach ($fields as $fieldName => $field) {
            if ($this->hasField($fieldName)) {
                $newPluginConfiguration
                    ->setFieldValue(
                        $fieldName,
                        $this->getFieldValue($fieldName)
                    );
            }
        }

        $this->setConfiguration($newPluginConfiguration->getConfiguration());

        return $this;
    }

    /**
     * Return new PluginConfiguration instance.
     *
     * @param array $configuration Configuration
     *
     * @return self New instance
     */
    public static function create(array $configuration)
    {
        return new self($configuration);
    }
}
