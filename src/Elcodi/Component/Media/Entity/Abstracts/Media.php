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

namespace Elcodi\Component\Media\Entity\Abstracts;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Media\Entity\Interfaces\MediaInterface;

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
     * @return $this self Object
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
