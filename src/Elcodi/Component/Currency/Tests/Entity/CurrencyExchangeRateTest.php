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

namespace Elcodi\Component\Currency\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Currency\Entity\CurrencyExchangeRate;

class CurrencyExchangeRateTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    /**
     * @var CurrencyExchangeRate
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CurrencyExchangeRate();
    }

    public function testSourceCurrency()
    {
        $sourceCurrency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $setterOutput = $this->object->setSourceCurrency($sourceCurrency);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSourceCurrency();
        $this->assertSame($sourceCurrency, $getterOutput);
    }

    public function testTargetCurrency()
    {
        $targetCurrency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $setterOutput = $this->object->setTargetCurrency($targetCurrency);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTargetCurrency();
        $this->assertSame($targetCurrency, $getterOutput);
    }

    public function testExchangeRate()
    {
        $exchangeRate = microtime(true);

        $setterOutput = $this->object->setExchangeRate($exchangeRate);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getExchangeRate();
        $this->assertSame($exchangeRate, $getterOutput);
    }
}
