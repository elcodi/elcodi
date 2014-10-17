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

namespace Elcodi\Component\Rule\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Rule\Entity\Abstracts\AbstractRule;
use Elcodi\Component\Rule\Entity\Interfaces\AbstractRuleInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleGroupInterface;

/**
 * Class RuleGroup
 */
class RuleGroup extends AbstractRule implements RuleGroupInterface
{
    /**
     * @var Collection
     *
     * Rules
     */
    protected $rules;

    /**
     * Sets Rules
     *
     * @param Collection $rules Rules
     *
     * @return RuleGroup Self object
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get Rules
     *
     * @return Collection Rules
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Add rule
     *
     * @param AbstractRuleInterface $rule Rule
     *
     * @return $this self Object
     */
    public function addRule(AbstractRuleInterface $rule)
    {
        $this->rules->add($rule);

        return $this;
    }

    /**
     * Remove rule
     *
     * @param AbstractRuleInterface $rule Rule
     *
     * @return $this self Object
     */
    public function removeRule(AbstractRuleInterface $rule)
    {
        $this->rules->removeElement($rule);

        return $this;
    }

    /**
     * Return all object contained expressions
     *
     * @return ArrayCollection Collection of expressions
     */
    public function getExpressionCollection()
    {
        $expressions = array();

        /**
         * @var AbstractRuleInterface $rule
         */
        foreach ($this->getRules() as $rule) {

            $expressions = array_merge(
                $expressions,
                $rule->getExpressionCollection()->toArray()
            );
        }

        return new ArrayCollection($expressions);
    }
}
