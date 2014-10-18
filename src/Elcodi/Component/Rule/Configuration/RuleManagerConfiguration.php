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

namespace Elcodi\Component\Rule\Configuration;

use Elcodi\Component\Rule\Configuration\Interfaces\ContextConfigurationInterface;
use Elcodi\Component\Rule\Configuration\Interfaces\ExpressionLanguageConfigurationInterface;
use Elcodi\Component\Rule\Services\Interfaces\ContextAwareInterface;
use Elcodi\Component\Rule\Services\Interfaces\ExpressionLanguageAwareInterface;
use Elcodi\Component\Rule\Services\RuleManager;

/**
 * Class RuleManagerConfigurator
 */
class RuleManagerConfiguration implements ContextConfigurationInterface, ExpressionLanguageConfigurationInterface
{
    /**
     * @var ContextConfigurationCollection
     *
     * Context Configuration Collection
     */
    protected $contextConfigurationCollection;

    /**
     * @var ExpressionLanguageConfigurationCollection
     *
     * ExpressionLanguage Configuration Collection
     */
    protected $expressionLanguageConfigurationCollection;

    /**
     * Construct method
     *
     * @param ContextConfigurationCollection            $contextConfigurationCollection            ContextConfiguration Collection
     * @param ExpressionLanguageConfigurationCollection $expressionLanguageConfigurationCollection ExpressionLanguageConfiguration Collection
     */
    public function __construct(
        ContextConfigurationCollection $contextConfigurationCollection,
        ExpressionLanguageConfigurationCollection $expressionLanguageConfigurationCollection
    )
    {
        $this->contextConfigurationCollection = $contextConfigurationCollection;
        $this->expressionLanguageConfigurationCollection = $expressionLanguageConfigurationCollection;
    }

    /**
     * Configure RuleManager
     *
     * @param RuleManager $ruleManager Rule Manager
     */
    public function configureRuleManager(RuleManager $ruleManager)
    {
        if ($ruleManager instanceof ContextAwareInterface) {

            $this->configureContext($ruleManager);
        }

        if ($ruleManager instanceof ExpressionLanguageAwareInterface) {

            $this->configureExpressionLanguage($ruleManager);
        }
    }

    /**
     * Configures context
     *
     * @param ContextAwareInterface $contextAware
     *
     * @return $this self Object
     */
    public function configureContext(ContextAwareInterface $contextAware)
    {
        /**
         * @var ContextConfigurationInterface $contextConfiguration
         */
        $contextConfigurationCollection = $this->contextConfigurationCollection->getContextConfigurations();
        foreach ($contextConfigurationCollection as $contextConfiguration) {

            $contextConfiguration->configureContext($contextAware);
        }

        return $this;
    }

    /**
     * Configures expression language
     *
     * @param ExpressionLanguageAwareInterface $expressionLanguageAware Expression Language aware
     *
     * @return $this self Object
     */
    public function configureExpressionLanguage(
        ExpressionLanguageAwareInterface $expressionLanguageAware
    )
    {
        /**
         * @var ExpressionLanguageConfigurationInterface $expressionLanguageConfiguration
         */
        $expressionLanguageConfigurations = $this->expressionLanguageConfigurationCollection->getExpressionLanguageConfigurations();
        foreach ($expressionLanguageConfigurations as $expressionLanguageConfiguration) {

            $expressionLanguageConfiguration->configureExpressionLanguage($expressionLanguageAware);
        }

        return $this;
    }
}
