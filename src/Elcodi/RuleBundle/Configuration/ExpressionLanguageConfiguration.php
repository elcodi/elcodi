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

use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcodi\RuleBundle\Configuration\Interfaces\ExpressionLanguageConfigurationInterface;
use Elcodi\RuleBundle\Services\Interfaces\ExpressionLanguageAwareInterface;

/**
 * Class ExpressionLanguageConfiguration
 */
class ExpressionLanguageConfiguration implements ExpressionLanguageConfigurationInterface
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected $container;

    /**
     * Construct method
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Configures expression language
     *
     * @param ExpressionLanguageAwareInterface $expressionLanguageAware Expression Language aware
     */
    public function configureExpressionLanguage(ExpressionLanguageAwareInterface $expressionLanguageAware)
    {
        $expressionLanguage = $expressionLanguageAware->getExpressionLanguage();
        $expressionLanguage
            ->register('service', function ($arg) {
                return sprintf('$this->get(%s)', $arg);
            }, function (array $variables, $value) {
                return $this->container->get($value);
            });

        $expressionLanguage
            ->register('parameter', function ($arg) {
                return sprintf('$this->getParameter(%s)', $arg);
            }, function (array $variables, $value) {
                return $this->container->getParameter($value);
            });
    }
}
