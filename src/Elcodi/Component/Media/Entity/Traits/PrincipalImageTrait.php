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

namespace Elcodi\Component\Media\Entity\Traits;

/**
 * Trait PrincipalImageTrait.
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
     * Set the principalImage.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $principalImage Principal image
     *
     * @return $this Self object
     */
    public function setPrincipalImage(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $principalImage = null)
    {
        $this->principalImage = $principalImage;

        return $this;
    }

    /**
     * Get the principalImage.
     *
     * @return \Elcodi\Component\Media\Entity\Interfaces\ImageInterface Principal image
     */
    public function getPrincipalImage()
    {
        return $this->principalImage;
    }
}
