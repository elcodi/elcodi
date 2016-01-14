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

namespace Elcodi\Component\Store\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Store\Entity\Store;
use Elcodi\Component\Store\StoreRoutingStrategy;

/**
 * Class StoreFactory.
 */
class StoreFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return Store Empty entity
     */
    public function create()
    {
        /**
         * @var Store $store
         */
        $classNamespace = $this->getEntityNamespace();
        $store = new $classNamespace();
        $store
            ->setIsCompany(true)
            ->setRoutingStrategy(StoreRoutingStrategy::STRATEGY_PREFIX_EXCEPT_DEFAULT)
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $store;
    }
}
