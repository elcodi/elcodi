<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */
 
namespace Elcodi\MediaBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;

/**
 * Class MediaInterface
 */
interface MediaInterface extends DateTimeInterface
{
    /**
     * The name of this media, e.g. for managing media documents
     *
     * For example an image file name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return MediaInterface self Object
     */
    public function setName($name);
}
