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

namespace Elcodi\Component\EntityTranslator\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\EntityTranslator\Entity\EntityTranslation;

class EntityTranslationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EntityTranslation
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new EntityTranslation();
    }

    public function testEntityId()
    {
        $entityId = sha1(rand());

        $setterOutput = $this->object->setEntityId($entityId);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEntityId();
        $this->assertSame($entityId, $getterOutput);
    }

    public function testEntityType()
    {
        $entityType = sha1(rand());

        $setterOutput = $this->object->setEntityType($entityType);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEntityType();
        $this->assertSame($entityType, $getterOutput);
    }

    public function testLocale()
    {
        $locale = sha1(rand());

        $setterOutput = $this->object->setLocale($locale);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLocale();
        $this->assertSame($locale, $getterOutput);
    }

    public function testTranslation()
    {
        $translation = sha1(rand());

        $setterOutput = $this->object->setTranslation($translation);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getTranslation();
        $this->assertSame($translation, $getterOutput);
    }

    public function testEntityField()
    {
        $entityField = sha1(rand());

        $setterOutput = $this->object->setEntityField($entityField);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEntityField();
        $this->assertSame($entityField, $getterOutput);
    }
}
