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
 
namespace Elcodi\MediaBundle\Factory;

use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\MediaBundle\Entity\Interfaces\ImageInterface;

/**
 * Class ImageFactory
 */
class ImageFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return ImageInterface Empty entity
     */
    public function create()
    {
        /**
         * @var ImageInterface $image
         */
        $classNamespace = $this->getEntityNamespace();
        $image = new $classNamespace();
        $image
            ->setCreatedAt(new DateTime)
            ->setEnabled(true);

        return $image;
    }
}
 