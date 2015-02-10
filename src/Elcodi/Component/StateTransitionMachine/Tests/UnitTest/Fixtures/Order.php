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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StatefulInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Traits\StateLinesTrait;

/**
 * Class Order
 */
class Order implements StatefulInterface
{
    use StateLinesTrait;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->stateLines = new ArrayCollection();
    }
}
