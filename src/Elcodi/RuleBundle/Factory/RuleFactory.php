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
 
namespace Elcodi\RuleBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\RuleBundle\Entity\Rule;


/**
 * Class RuleFactory
 */
class RuleFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return Rule Empty entity
     */
    public function create()
    {
        /**
         * @var Rule $rule
         */
        $classNamespace = $this->getEntityNamespace();
        $rule = new $classNamespace();
        $rule
            ->setRuleGroups(new ArrayCollection())
            ->setEnabled(true);

        return $rule;
    }
}
 