<?php

/**
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
 */

namespace Elcodi\AttributeBundle\Tests\UnitTest\Factory;

use Elcodi\AttributeBundle\Factory\ValueFactory;
use PHPUnit_Framework_TestCase;

/**
 * Class ValueFactoryTest
 */
class ValueFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test object creation
     *
     * @group attribute
     */
    public function testCreate()
    {
        $valueFactory = new ValueFactory();
        $valueFactory
            ->setEntityNamespace('Elcodi\AttributeBundle\Entity\Value');

        $value = $valueFactory->create();

        $this->assertInstanceOf('Elcodi\AttributeBundle\Entity\Value', $value);
    }
}