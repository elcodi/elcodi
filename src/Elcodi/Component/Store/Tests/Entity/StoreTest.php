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

namespace Elcodi\Component\Store\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Store\Entity\Store;

class StoreTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var Store
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Store();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testLeitmotiv()
    {
        $leitmotiv = sha1(rand());

        $setterOutput = $this->object->setLeitmotiv($leitmotiv);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLeitmotiv();
        $this->assertSame($leitmotiv, $getterOutput);
    }

    public function testEmail()
    {
        $email = sha1(rand()) . '@example.com';

        $setterOutput = $this->object->setEmail($email);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEmail();
        $this->assertSame($email, $getterOutput);
    }

    public function testIsCompany()
    {
        $isCompany = (bool) rand(0, 1);

        $setterOutput = $this->object->setIsCompany($isCompany);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getIsCompany();
        $this->assertSame($isCompany, $getterOutput);
    }

    public function testCif()
    {
        $cif = sha1(rand());

        $setterOutput = $this->object->setCif($cif);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCif();
        $this->assertSame($cif, $getterOutput);
    }

    public function testTracker()
    {
        $tracker = sha1(rand());

        $setterOutput = $this->object->setTracker($tracker);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTracker();
        $this->assertSame($tracker, $getterOutput);
    }

    public function testTemplate()
    {
        $template = sha1(rand());

        $setterOutput = $this->object->setTemplate($template);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTemplate();
        $this->assertSame($template, $getterOutput);
    }

    public function testUseStock()
    {
        $useStock = (bool) rand(0, 1);

        $setterOutput = $this->object->setUseStock($useStock);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getUseStock();
        $this->assertSame($useStock, $getterOutput);
    }

    public function testAddress()
    {
        $address = sha1(rand());

        $setterOutput = $this->object->setAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testDefaultLanguage()
    {
        $defaultLanguage = $this->getMock('Elcodi\Component\Language\Entity\Interfaces\LanguageInterface');

        $setterOutput = $this->object->setDefaultLanguage($defaultLanguage);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDefaultLanguage();
        $this->assertSame($defaultLanguage, $getterOutput);
    }

    public function testDefaultCurrency()
    {
        $defaultCurrency = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface');

        $setterOutput = $this->object->setDefaultCurrency($defaultCurrency);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDefaultCurrency();
        $this->assertSame($defaultCurrency, $getterOutput);
    }

    public function testRoutingStrategy()
    {
        $routingStrategy = sha1(rand());

        $setterOutput = $this->object->setRoutingStrategy($routingStrategy);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getRoutingStrategy();
        $this->assertSame($routingStrategy, $getterOutput);
    }

    public function testLogo()
    {
        $logo = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setLogo($logo);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLogo();
        $this->assertSame($logo, $getterOutput);
    }

    public function testSecondaryLogo()
    {
        $secondaryLogo = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setSecondaryLogo($secondaryLogo);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSecondaryLogo();
        $this->assertSame($secondaryLogo, $getterOutput);
    }

    public function testMobileLogo()
    {
        $mobileLogo = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setMobileLogo($mobileLogo);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMobileLogo();
        $this->assertSame($mobileLogo, $getterOutput);
    }

    public function testHeaderImage()
    {
        $headerImage = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setHeaderImage($headerImage);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getHeaderImage();
        $this->assertSame($headerImage, $getterOutput);
    }

    public function testBackgroundImage()
    {
        $backgroundImage = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setBackgroundImage($backgroundImage);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getBackgroundImage();
        $this->assertSame($backgroundImage, $getterOutput);
    }
}
