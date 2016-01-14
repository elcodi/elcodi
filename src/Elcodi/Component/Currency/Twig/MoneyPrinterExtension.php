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

namespace Elcodi\Component\Currency\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Currency\Services\MoneyPrinter;

/**
 * Class MoneyPrinterExtension.
 *
 * Money printer extension for twig
 */
class MoneyPrinterExtension extends Twig_Extension
{
    /**
     * @var MoneyPrinter
     *
     * Money printer
     */
    private $moneyPrinter;

    /**
     * Construct method.
     *
     * @param MoneyPrinter $moneyPrinter Money printer
     */
    public function __construct(MoneyPrinter $moneyPrinter)
    {
        $this->moneyPrinter = $moneyPrinter;
    }

    /**
     * Return all filters.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('print_convert_money', [
                $this->moneyPrinter,
                'printConvertMoney',
            ]),
            new Twig_SimpleFilter('print_money', [
                $this->moneyPrinter,
                'printMoney',
            ]),
            new Twig_SimpleFilter('print_money_from_value', [
                $this->moneyPrinter,
                'printMoneyFromValue',
            ]),
        ];
    }

    /**
     * return extension name.
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'money_printer_extension';
    }
}
