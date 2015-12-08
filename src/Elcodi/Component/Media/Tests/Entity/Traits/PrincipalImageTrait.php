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

namespace Elcodi\Component\Media\Tests\Entity\Traits;

trait PrincipalImageTrait
{
    public function testPrincipalImage()
    {
        $principalImage = $this->getMock('Elcodi\Component\Media\Entity\Interfaces\ImageInterface');

        $setterOutput = $this->object->setPrincipalImage($principalImage);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPrincipalImage();
        $this->assertSame($principalImage, $getterOutput);
    }
}
