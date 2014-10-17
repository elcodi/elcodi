<?php

/*
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

namespace Elcodi\Component\Media\Entity\Traits;

/**
 * Class PrincipalImageTrait
 */
trait PrincipalImageTrait
{
    /**
     * @var \Elcodi\Component\Media\Entity\Interfaces\ImageInterface
     *
     * Principal image
     */
    protected $principalImage;

    /**
     * Set the principalImage
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $principalImage Principal image
     *
     * @return $this self Object
     */
    public function setPrincipalImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $principalImage = null)
    {
        $this->principalImage = $principalImage;

        return $this;
    }

    /**
     * Get the principalImage
     *
     * @return \Elcodi\Component\Media\Entity\Interfaces\ImageInterface Principal image
     */
    public function getPrincipalImage()
    {
        return $this->principalImage;
    }
}
