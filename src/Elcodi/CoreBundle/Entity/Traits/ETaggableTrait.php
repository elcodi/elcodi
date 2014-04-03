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

namespace Elcodi\CoreBundle\Entity\Traits;

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

        if ($this instanceof AbstractEntity) {

            $sha1Able .= $this->getId();
        } else {

            $sha1Able .= spl_object_hash($this);
        }

        if (in_array('Elcodi\CoreBundle\Entity\Traits\DateTimeTrait', class_uses($this))) {

            $sha1Able .= $this->getUpdatedAt()->getTimestamp();
        }

        return sha1($sha1Able);
    }
}
