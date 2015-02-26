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

namespace Elcodi\Component\Plugin\Entity;

/**
 * Class Plugin
 */
class Plugin
{
    /**
     * @var string
     *
     * Bundle
     */
    protected $bundle;

    /**
     * @var string
     *
     * Namespace
     */
    protected $namespace;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var string
     *
     * Version
     */
    protected $version;

    /**
     * @var string
     *
     * Author
     */
    protected $author;

    /**
     * @var string
     *
     * Year
     */
    protected $year;

    /**
     * @var string
     *
     * Url
     */
    protected $url;

    /**
     * @var string
     *
     * Fa-icon
     */
    protected $faIcon;

    /**
     * @var string
     *
     * Configuration route
     */
    protected $configurationRoute;

    /**
     * @var boolean
     *
     * Enabled
     */
    protected $enabled;

    /**
     * @var array
     *
     * Configuration
     */
    protected $configuration;

    /**
     * @var boolean
     *
     * Visible
     */
    protected $visible;

    /**
     * Construct new plugin instance
     *
     * @param string  $author
     * @param string  $bundle
     * @param array   $configuration
     * @param string  $configurationRoute
     * @param string  $description
     * @param boolean $enabled
     * @param string  $faIcon
     * @param string  $name
     * @param string  $namespace
     * @param string  $url
     * @param string  $version
     * @param string  $year
     * @param boolean $visible
     */
    public function __construct(
        $author,
        $bundle,
        array $configuration,
        $configurationRoute,
        $description,
        $enabled,
        $faIcon,
        $name,
        $namespace,
        $url,
        $version,
        $year,
        $visible
    ) {
        $this->author = $author;
        $this->bundle = $bundle;
        $this->configuration = $configuration;
        $this->configurationRoute = $configurationRoute;
        $this->description = $description;
        $this->enabled = $enabled;
        $this->faIcon = $faIcon;
        $this->name = $name;
        $this->namespace = $namespace;
        $this->url = $url;
        $this->version = $version;
        $this->year = $year;
        $this->visible = $visible;
    }

    /**
     * Get Author
     *
     * @return string Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get Bundle
     *
     * @return string Bundle
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Get Configuration
     *
     * @return mixed Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get ConfigurationRoute
     *
     * @return string ConfigurationRoute
     */
    public function getConfigurationRoute()
    {
        return $this->configurationRoute;
    }

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get Enabled
     *
     * @return boolean Enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Get FaIcon
     *
     * @return string FaIcon
     */
    public function getFaIcon()
    {
        return $this->faIcon;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Namespace
     *
     * @return string Namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get Url
     *
     * @return string Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get Version
     *
     * @return string Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get Year
     *
     * @return string Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Is visible
     *
     * @return bool Visible
     */
    public function isVisible()
    {
        return $this->visible;
    }
}
