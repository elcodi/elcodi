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

namespace Elcodi\RuleBundle\Configuration;

use Elcodi\RuleBundle\Configuration\Interfaces\ContextConfigurationInterface;
use Elcodi\RuleBundle\Configuration\Interfaces\ExpressionLanguageConfigurationInterface;
use Elcodi\RuleBundle\Services\Interfaces\ContextAwareInterface;
use Elcodi\RuleBundle\Services\Interfaces\ExpressionLanguageAwareInterface;
use Elcodi\RuleBundle\Services\RuleManager;

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
     * @param ContextAwareInterface $contextAware
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
    }

    /**
     * Configures expression language
     *
     * @param ExpressionLanguageAwareInterface $expressionLanguageAware Expression Language aware
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
    }
}
