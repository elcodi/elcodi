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

namespace Elcodi\CoreBundle\Transformer\Interfaces;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

/**
 * Class TransformerInterface
 *
 * This interface is for transformers.
 *
 * A transformer has only one simple behaviour, and is to transform an entity
 * to an output format.
 */
interface TransformerInterface
{
    /**
     * Transforms an entity
     *
     * @param AbstractEntity $entity Entity to transform
     *
     * @return mixed Entity transformed
     */
    public function transform(AbstractEntity $entity);
}
