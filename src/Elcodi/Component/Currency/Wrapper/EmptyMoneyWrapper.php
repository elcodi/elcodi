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

namespace Elcodi\Component\Currency\Wrapper;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class EmptyMoneyWrapper.
 */
class EmptyMoneyWrapper implements WrapperInterface
{
    /**
     * @var DefaultCurrencyWrapper
     *
     * Default currency wrapper
     */
    private $defaultCurrencyWrapper;

    /**
     * Currency wrapper constructor.
     *
     * @param DefaultCurrencyWrapper $defaultCurrencyWrapper Default currency wrapper
     */
    public function __construct(DefaultCurrencyWrapper $defaultCurrencyWrapper)
    {
        $this->defaultCurrencyWrapper = $defaultCurrencyWrapper;
    }

    /**
     * Get empty money value, created with default language.
     *
     * @return Money Empty-valued money
     */
    public function get()
    {
        return Money::create(
            0,
            $this
                ->defaultCurrencyWrapper
                ->get()
        );
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        return $this;
    }
}
