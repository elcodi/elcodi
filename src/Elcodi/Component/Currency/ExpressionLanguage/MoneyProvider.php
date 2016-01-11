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

namespace Elcodi\Component\Currency\ExpressionLanguage;

use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Repository\CurrencyRepository;

/**
 * Class MoneyProvider.
 *
 * Extends ExpressionLanguage to create money objects
 */
class MoneyProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @var WrapperInterface
     *
     * Currency wrapper to get the default currency
     */
    private $defaultCurrencyWrapper;

    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;

    /**
     * Construct.
     *
     * @param WrapperInterface   $defaultCurrencyWrapper Default Currency wrapper
     * @param CurrencyRepository $currencyRepository     Currency Repository
     */
    public function __construct(
        WrapperInterface $defaultCurrencyWrapper,
        CurrencyRepository $currencyRepository
    ) {
        $this->defaultCurrencyWrapper = $defaultCurrencyWrapper;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Return functions.
     *
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            /**
             * Evaluate a rule by name.
             */
            new ExpressionFunction(
                'money',
                function () {
                    throw new RuntimeException(
                        'Function "money" can\'t be compiled.'
                    );
                },
                function (array $context, $amount, $currencyIso = null) {

                    if ($currencyIso === null) {
                        $currency = $this
                            ->defaultCurrencyWrapper
                            ->get();
                    } else {
                        /**
                         * @var CurrencyInterface $currency
                         */
                        $currency = $this
                            ->currencyRepository
                            ->findOneBy([
                                'iso' => $currencyIso,
                            ]);
                    }

                    return Money::create(
                        $amount * 100,
                        $currency
                    );
                }
            ),
        ];
    }
}
