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

namespace Elcodi\Component\Rule\ExpressionLanguage\Provider;

use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class MoneyProvider
 *
 * Extends ExpressionLanguage to create money objects
 */
class MoneyProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @var CurrencyWrapper
     */
    protected $currencyWrapper;

    /**
     * @param CurrencyWrapper $currencyWrapper
     */
    public function __construct(CurrencyWrapper $currencyWrapper)
    {
        $this->currencyWrapper = $currencyWrapper;
    }

    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            /**
             * Evaluate a rule by name
             */
            new ExpressionFunction(
                'money',
                function ($arg) {
                    throw new RuntimeException(
                        'Function "money" can\'t be compiled.'
                    );
                },
                function (array $context, $amount) {

                    $currency = $this
                        ->currencyWrapper
                        ->getDefaultCurrency();

                    $centsPerUnit = 100;

                    return Money::create($amount * $centsPerUnit, $currency);
                }
            ),
        ];
    }
}
