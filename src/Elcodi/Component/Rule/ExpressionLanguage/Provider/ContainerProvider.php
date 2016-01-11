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

namespace Elcodi\Component\Rule\ExpressionLanguage\Provider;

use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class ContainerProvider.
 *
 * Extends ExpressionLanguage to access services and parameters in current container
 */
class ContainerProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    private $container;

    /**
     * Construct method.
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get functions.
     *
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            /**
             * Get a service from the container.
             */
            new ExpressionFunction(
                'service',
                function () {
                    throw new RuntimeException(
                        'Function "rule" can\'t be compiled.'
                    );
                },
                function (array $context, $value) {
                    return $this
                        ->container
                        ->get($value);
                }
            ),

            /**
             * Get a parameter from the container.
             */
            new ExpressionFunction(
                'parameter',
                function () {
                    throw new RuntimeException(
                        'Function "rule" can\'t be compiled.'
                    );
                },
                function (array $context, $value) {
                    return $this
                        ->container
                        ->getParameter($value);
                }
            ),
        ];
    }
}
