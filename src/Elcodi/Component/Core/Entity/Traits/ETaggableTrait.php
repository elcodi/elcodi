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

namespace Elcodi\Component\Core\Entity\Traits;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * trait for entities that can hash their state and return an ETag header
 */
trait ETaggableTrait
{
    /**
     * Return etag from entity
     *
     * @return string ETag
     */
    public function getEtag()
    {
        $sha1Able = '';

        if ($this instanceof IdentifiableInterface) {

            $sha1Able .= $this->getId();
        } else {

            $sha1Able .= spl_object_hash($this);
        }

        if (in_array('Elcodi\Component\Core\Entity\Traits\DateTimeTrait', class_uses($this))) {

            $sha1Able .= $this->getUpdatedAt()->getTimestamp();
        }

        return sha1($sha1Able);
    }
}
