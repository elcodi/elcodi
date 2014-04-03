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

namespace Elcodi\CartBundle\Factory;

use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CartBundle\Entity\OrderHistory;

/**
 * Class OrderHistoryFactory
 */
class OrderHistoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of OrderHistory
     *
     * @return OrderHistory New OrderHistory entity
     */
    public function create()
    {
        /**
         * @var OrderHistory $orderHistory
         */
        $classNamespace = $this->getEntityNamespace();
        $orderHistory = new $classNamespace();
        $orderHistory->setCreatedAt(new DateTime);

        return $orderHistory;
    }
}
