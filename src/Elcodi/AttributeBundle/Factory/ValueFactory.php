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

use Elcodi\AttributeBundle\Entity\Value;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Factory for Value entities
 */
class ValueFactory extends AbstractFactory
{
    /**
     * Creates a Value instance
     *
     * @return Value New Value entity
     */
    public function create()
    {
        /**
         * @var Value $value
         */
        $classNamespace = $this->getEntityNamespace();
        $value = new $classNamespace();
        $value
            ->setName('')
            ->setDisplayName('')
            ->setEnabled(false)
            ->setCreatedAt(new \DateTime);

        return $value;
    }
} 