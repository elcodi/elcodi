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

namespace Elcodi\Component\Core\Entity\Traits;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * trait for entities that can hash their state and return an ETag header.
 */
trait ETaggableTrait
{
    /**
     * Return etag from entity.
     *
     * @return string ETag
     */
    public function getEtag()
    {
        $sha1Able = ($this instanceof IdentifiableInterface)
            ? $this->getId()
            : spl_object_hash($this);

        if ($this instanceof DateTimeInterface) {
            $sha1Able .= $this
                ->getUpdatedAt()
                ->getTimestamp();
        }

        return sha1($sha1Able);
    }
}
