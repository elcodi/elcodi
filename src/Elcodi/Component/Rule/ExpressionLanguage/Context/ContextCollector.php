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

namespace Elcodi\Component\Rule\ExpressionLanguage\Context;

use Elcodi\Component\Rule\ExpressionLanguage\Interfaces\ExpressionContextProviderInterface;

/**
 * Class ContextCollector.
 *
 * Provides context for ExpressionLanguage
 */
class ContextCollector implements ExpressionContextProviderInterface
{
    /**
     * @var ExpressionContextProviderInterface[]
     *
     * Context providers
     */
    private $contextProviders;

    /**
     * Constructor.
     *
     * @param ExpressionContextProviderInterface[] $contextProviders Context providers
     */
    public function __construct(array $contextProviders = [])
    {
        $this->contextProviders = $contextProviders;
    }

    /**
     * Get provided context.
     *
     * @return array
     */
    public function getContext()
    {
        $context = [];
        foreach ($this->contextProviders as $contextProvider) {
            $context[] = $contextProvider->getContext();
        }

        return empty($context) ? $context : call_user_func_array('array_merge', $context);
    }
}
