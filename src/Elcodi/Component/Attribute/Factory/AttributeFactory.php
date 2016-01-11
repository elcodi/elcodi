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

namespace Elcodi\Component\Attribute\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Attribute\Entity\Attribute;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Factory for Attribute entities.
 */
class AttributeFactory extends AbstractFactory
{
    /**
     * Creates an Attribute instance.
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
        $attribute->setEnabled(true)
            ->setValues(new ArrayCollection())
            ->setCreatedAt($this->now());

        return $attribute;
    }
}
