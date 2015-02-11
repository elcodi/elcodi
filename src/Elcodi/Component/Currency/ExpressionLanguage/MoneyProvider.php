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

namespace Elcodi\Component\Currency\ExpressionLanguage;

use Doctrine\Common\Persistence\ObjectRepository;
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
     *
     * Currency wrapper to get the default currency
     */
    protected $currencyWrapper;

    /**
     * @var ObjectRepository
     *
     * Currency repository
     */
    protected $repository;

    /**
     * @param CurrencyWrapper  $currencyWrapper
     * @param ObjectRepository $repository
     */
    public function __construct(CurrencyWrapper $currencyWrapper, ObjectRepository $repository)
    {
        $this->currencyWrapper = $currencyWrapper;
        $this->repository = $repository;
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
                function (array $context, $amount, $currency = null) {

                    if ($currency === null) {
                        $currency = $this
                            ->currencyWrapper
                            ->getDefaultCurrency();
                    } else {
                        $currency = $this
                            ->repository
                            ->findOneBy([
                                'iso' => $currency,
                            ]);
                    }

                    $centsPerUnit = 100;

                    return Money::create($amount * $centsPerUnit, $currency);
                }
            ),
        ];
    }
}
