<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Entity\Abstracts;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\MediaBundle\Entity\Interfaces\MediaInterface;

/**
 * Class Media
 */
abstract class Media extends AbstractEntity implements MediaInterface
{
    use EnabledTrait, DateTimeTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * The name of this media, e.g. for managing media documents
     *
     * For example an image file name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return MediaInterface self Object
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
