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

namespace Elcodi\Component\Currency\Factory\Abstracts;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;

/**
 * Class AbstractPurchasableFactory.
 *
 * Abstract factory for purchasable entities that need
 * a default currency to be properly initialized
 */
abstract class AbstractPurchasableFactory extends AbstractFactory
{
    /**
     * @var EmptyMoneyWrapper
     *
     * Empty money wrapper
     */
    protected $emptyMoneyWrapper;

    /**
     * Factory constructor.
     *
     * @param EmptyMoneyWrapper $emptyMoneyWrapper Empty money wrapper
     */
    public function __construct(EmptyMoneyWrapper $emptyMoneyWrapper)
    {
        $this->emptyMoneyWrapper = $emptyMoneyWrapper;
    }

    /**
     * Returns a zero-initialized Money object
     * to be assigned to product prices.
     *
     * @return MoneyInterface
     */
    protected function createZeroAmountMoney()
    {
        return $this
            ->emptyMoneyWrapper
            ->get();
    }
}
