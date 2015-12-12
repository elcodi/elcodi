<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Product\Tests\Entity\Traits;

trait ProductPriceTrait
{
    public function testPrice()
    {
        $price = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface');
        $amount = rand();
        $currency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $price
            ->method('getAmount')
            ->willReturn($amount);
        $price
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setPrice($price);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPrice();
        $this->assertInstanceOf('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface', $getterOutput);
    }

    public function testReducedPrice()
    {
        $reducedPrice = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface');
        $amount = rand();
        $currency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $currency
            ->method('getIso')
            ->willReturn('EUR');

        $reducedPrice
            ->method('getAmount')
            ->willReturn($amount);
        $reducedPrice
            ->method('getCurrency')
            ->willReturn($currency);

        $setterOutput = $this->object->setReducedPrice($reducedPrice);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getReducedPrice();
        $this->assertInstanceOf('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface', $getterOutput);
    }
}
