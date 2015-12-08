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

namespace Elcodi\Component\Payment\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Payment\Entity\PaymentMethod;

class PaymentMethodTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentMethod
     */
    protected $object;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $script;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->id = sha1(rand());
        $this->name = sha1(rand());
        $this->description = sha1(rand());
        $this->url = sha1(rand());
        $this->imageUrl = sha1(rand());
        $this->script = sha1(rand());

        $this->object = new PaymentMethod(
            $this->id,
            $this->name,
            $this->description,
            $this->url,
            $this->imageUrl,
            $this->script
        );
    }

    public function testGetId()
    {
        $this->assertSame($this->id, $this->object->getId());
    }

    public function testGetName()
    {
        $this->assertSame($this->name, $this->object->getName());
    }

    public function testGetDescription()
    {
        $this->assertSame($this->description, $this->object->getDescription());
    }

    public function testGetUrl()
    {
        $this->assertSame($this->url, $this->object->getUrl());
    }

    public function testGetImageUrl()
    {
        $this->assertSame($this->imageUrl, $this->object->getImageUrl());
    }

    public function testGetScript()
    {
        $this->assertSame($this->script, $this->object->getScript());
    }
}
