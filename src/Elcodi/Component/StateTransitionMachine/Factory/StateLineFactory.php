<?php

/*
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

namespace Elcodi\Component\StateTransitionMachine\Factory;

use DateTime;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\StateTransitionMachine\Entity\StateLine;

/**
 * Class StateLineFactory
 */
class StateLineFactory extends AbstractFactory
{
    /**
     * Creates an instance of StateLine entity
     *
     * @return StateLine Empty entity
     */
    public function create()
    {
        /**
         * @var StateLine $stateLine
         */
        $classNamespace = $this->getEntityNamespace();
        $stateLine = new $classNamespace();
        $stateLine
            ->setCreatedAt(new DateTime());

        return $stateLine;
    }
}
