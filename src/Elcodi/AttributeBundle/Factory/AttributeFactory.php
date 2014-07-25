<?php

/**
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

namespace Elcodi\AttributeBundle\Factory;

use Elcodi\AttributeBundle\Entity\Attribute;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Factory for Attribute entities
 */
class AttributeFactory extends AbstractFactory
{
    /**
     * Creates an Attribute instance
     *
     * @return Attribute New Attribute entity
     */
    public function create()
    {
        /**
         * @var Attribute $attribute
         */
        $classNamespace = $this->getEntityNamespace();
        $attribute = new $classNamespace();
        $attribute
            ->setName('')
            ->setDisplayName('')
            ->setEnabled(false)
            ->setCreatedAt(new \DateTime);

        return $attribute;
    }
}
