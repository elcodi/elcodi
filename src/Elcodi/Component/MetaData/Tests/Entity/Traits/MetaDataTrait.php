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

namespace Elcodi\Component\MetaData\Tests\Entity\Traits;

trait MetaDataTrait
{
    public function testMetaDescription()
    {
        $metaDescription = sha1(rand());

        $setterOutput = $this->object->setMetaDescription($metaDescription);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMetaDescription();
        $this->assertSame($metaDescription, $getterOutput);
    }

    public function testMetaKeywords()
    {
        $metaKeywords = sha1(rand());

        $setterOutput = $this->object->setMetaKeywords($metaKeywords);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMetaKeywords();
        $this->assertSame($metaKeywords, $getterOutput);
    }

    public function testMetaTitle()
    {
        $metaTitle = sha1(rand());

        $setterOutput = $this->object->setMetaTitle($metaTitle);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMetaTitle();
        $this->assertSame($metaTitle, $getterOutput);
    }
}
