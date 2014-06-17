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

namespace Elcodi\RuleBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\RuleBundle\Entity\RuleGroup;

/**
 * Class RuleGroupFactory
 */
class RuleGroupFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return RuleGroup Empty entity
     */
    public function create()
    {
        /**
         * @var RuleGroup $ruleGroup
         */
        $classNamespace = $this->getEntityNamespace();
        $ruleGroup = new $classNamespace();
        $ruleGroup
            ->setRules(new ArrayCollection())
            ->setEnabled(true);

        return $ruleGroup;
    }
}
