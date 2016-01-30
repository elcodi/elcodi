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

namespace Elcodi\Component\Rule\Services\Interfaces;

use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Interface RuleManagerInterface.
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface RuleManagerInterface
{
    /**
     * Evaluates a rule and returns result.
     *
     * @param RuleInterface $rule
     * @param array         $context
     *
     * @return mixed
     */
    public function evaluate(RuleInterface $rule, array $context = []);
}
