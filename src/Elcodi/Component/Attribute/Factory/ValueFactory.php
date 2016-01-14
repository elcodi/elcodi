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

use Elcodi\Component\Attribute\Entity\Value;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Factory for Value entities.
 */
class ValueFactory extends AbstractFactory
{
    /**
     * Creates a Value instance.
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

        return $value;
    }
}
