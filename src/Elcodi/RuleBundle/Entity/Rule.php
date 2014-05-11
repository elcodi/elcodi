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
 
namespace Elcodi\RuleBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;

/**
 * Class Rule
 */
class Rule extends AbstractEntity implements RuleInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Rule name
     */
    protected $name;

    /**
     * @var string
     *
     * Rule code
     */
    protected $code;

    /**
     * @var string
     *
     * Expression
     */
    protected $expression;

    /**
     * @var Collection
     *
     * Rule Groups
     */
    protected $ruleGroups;

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return Rule Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return Rule Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Expression
     *
     * @param string $expression Expression
     *
     * @return Rule Self object
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * Get Expression
     *
     * @return string Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * Sets Rule Groups
     *
     * @param mixed $ruleGroups Rule Groups
     *
     * @return Rule Self object
     */
    public function setRuleGroups($ruleGroups)
    {
        $this->ruleGroups = $ruleGroups;

        return $this;
    }

    /**
     * Get Rule Groups
     *
     * @return Collection Rule Groups
     */
    public function getRuleGroups()
    {
        return $this->ruleGroups;
    }

    /**
     * Add Rule group
     *
     * @param RuleGroupInterface $ruleGroup Rule Group
     *
     * @return Rule self Object
     */
    public function addRuleGroup(RuleGroupInterface $ruleGroup)
    {
        $this->ruleGroups->add($ruleGroup);

        return $this;
    }

    /**
     * Removed Rule Group
     *
     * @param RuleGroupInterface $ruleGroup Rule Group
     *
     * @return Rule self Object
     */
    public function removeRuleGroup(RuleGroupInterface $ruleGroup)
    {
        $this->ruleGroups->removeElement($ruleGroup);

        return $this;
    }
}
 