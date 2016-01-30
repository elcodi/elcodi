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

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * Class Plugin.
 */
class Plugin
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Namespace
     */
    protected $namespace;

    /**
     * @var string
     *
     * Path
     */
    protected $hash;

    /**
     * @var string
     *
     * Type
     */
    protected $type;

    /**
     * @var string
     *
     * Category
     */
    protected $category;

    /**
     * @var PluginConfiguration
     *
     * Configuration
     */
    protected $configuration;

    /**
     * Construct new plugin instance.
     *
     * @param string              $namespace     Namespace
     * @param string              $type          Type
     * @param string              $category      Plugin category
     * @param PluginConfiguration $configuration Configuration
     * @param bool                $enabled       If the plugin is enabled
     */
    public function __construct(
        $namespace,
        $type,
        $category,
        PluginConfiguration $configuration,
        $enabled
    ) {
        $this->namespace = $namespace;
        $this->hash = sha1($namespace);
        $this->type = $type;
        $this->category = $category;
        $this->configuration = $configuration;
        $this->enabled = $enabled;
    }

    /**
     * Get Namespace.
     *
     * @return string Namespace
     */
    public function getNamespace()
    {
        return trim($this->namespace, '\\');
    }

    /**
     * Get Bundle name.
     *
     * @return string Bundle name
     */
    public function getBundleName()
    {
        $bundleParts = explode('\\', $this->getNamespace());
        $bundleName = end($bundleParts);

        return $bundleName;
    }

    /**
     * Get Bundle name.
     *
     * @return string Bundle name
     */
    public function getBundleNamespaceRoot()
    {
        $bundleParts = explode('\\', $this->getNamespace());
        unset($bundleParts[count($bundleParts) - 1]);

        return implode('\\', $bundleParts);
    }

    /**
     * Get Path.
     *
     * @return string Path
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get Type.
     *
     * @return string Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Category.
     *
     * @return string Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get configuration.
     *
     * @return PluginConfiguration Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get configuration value.
     *
     * @param string $configurationName Configuration element name
     *
     * @return mixed|null Configuration element value
     */
    public function getConfigurationValue($configurationName)
    {
        return $this
            ->getConfiguration()
            ->get($configurationName);
    }

    /**
     * Get fields.
     *
     * @return array Fields
     */
    public function getFields()
    {
        return $this
            ->getConfiguration()
            ->getFields();
    }

    /**
     * Has fields.
     *
     * @return bool Has fields
     */
    public function hasFields()
    {
        $fields = $this->getFields();

        return !empty($fields);
    }

    /**
     * Get field value.
     *
     * @param string $fieldName Field name
     *
     * @return array|null Field
     */
    public function getField($fieldName)
    {
        return $this
            ->getConfiguration()
            ->getField($fieldName);
    }

    /**
     * Has field.
     *
     * @param string $fieldName Field name
     *
     * @return bool Has field
     */
    public function hasField($fieldName)
    {
        return $this
            ->getConfiguration()
            ->hasField($fieldName);
    }

    /**
     * Get an array with all field values, indexed by the field name.
     *
     * @return array Fields with values
     */
    public function getFieldValues()
    {
        return array_map(
            function ($field) {
                return isset($field['data'])
                    ? $field['data']
                    : null;
            },
            $this->getFields()
        );
    }

    /**
     * Get a field value.
     *
     * @param string $fieldName Field name
     *
     * @return mixed Field value
     */
    public function getFieldValue($fieldName)
    {
        return $this
            ->configuration
            ->getFieldValue($fieldName);
    }

    /**
     * Get an array with all field values, indexed by the field name.
     *
     * @param array $fieldValues All field values to be set
     *
     * @return $this Self object
     */
    public function setFieldValues(array $fieldValues)
    {
        foreach ($fieldValues as $field => $fieldValue) {
            $this
                ->configuration
                ->setFieldValue(
                    $field,
                    $fieldValue
                );
        }

        return $this;
    }

    /**
     * Plugin is usable.
     *
     * @param array $requiredFields Fields to check
     *
     * @return bool Plugin is usable
     */
    public function isUsable(array $requiredFields = [])
    {
        return array_reduce(
            $requiredFields,
            function ($canBeUsed, $checkableField) {

                return
                    $canBeUsed &&
                    $this->hasField($checkableField) &&
                    (
                        false === $this->getField($checkableField)['required'] ||
                        $this->getFieldValue($checkableField)
                    );
            },
            $this->isEnabled()
        );
    }

    /**
     * Plugin is usable using all defined fields.
     *
     * @return bool Plugin is usable
     */
    public function guessIsUsable()
    {
        return $this
            ->isUsable(
                array_keys($this->getFields())
            );
    }

    /**
     * Merge this plugin instance with a new one, and saves the result in
     * this instance.
     *
     * This method will give priority to its own properties values.
     *
     * @param Plugin $newPlugin New plugin configuration
     *
     * @return $this Self object
     */
    public function merge(Plugin $newPlugin)
    {
        if ($newPlugin->getNamespace() !== $this->getNamespace()) {
            throw new RuntimeException('Both plugins cannot be merged');
        }

        $this
            ->configuration
            ->merge($newPlugin->getConfiguration());

        return $this;
    }

    /**
     * Return new plugin instance.
     *
     * @param string              $namespace     Namespace
     * @param string              $type          Type
     * @param string              $category      Plugin category
     * @param PluginConfiguration $configuration Configuration
     * @param bool                $enabled       If the plugin should be enabled
     *
     * @return Plugin New instance
     */
    public static function create(
        $namespace,
        $type,
        $category,
        PluginConfiguration $configuration,
        $enabled
    ) {
        return new self(
            $namespace,
            $type,
            $category,
            $configuration,
            $enabled
        );
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return class_exists($this->getNamespace());
    }
}
