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

namespace Elcodi\CartBundle\Factory;

use DateTime;

use Elcodi\CartBundle\Entity\OrderLineHistory;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class OrderLineHistoryFactory
 */
class OrderLineHistoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of OrderLineHistory
     *
     * @return OrderLineHistory New OrderLineHistory entity
     */
    public function create()
    {
        /**
         * @var OrderLineHistory $orderLine
         */
        $classNamespace = $this->getEntityNamespace();
        $orderLineHistory = new $classNamespace();
        $orderLineHistory->setCreatedAt(new DateTime);

        return $orderLineHistory;
    }
}
