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
 
namespace Elcodi\RuleBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * Class RuleInterface
 */
interface RuleInterface extends EnabledInterface
{
    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return RuleInterface Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return RuleInterface Self object
     */
    public function setCode($code);

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Sets Expression
     *
     * @param string $expression Expression
     *
     * @return RuleInterface Self object
     */
    public function setExpression($expression);

    /**
     * Get Expression
     *
     * @return string Expression
     */
    public function getExpression();

    /**
     * Sets Rule Groups
     *
     * @param mixed $ruleGroups Rule Groups
     *
     * @return RuleInterface Self object
     */
    public function setRuleGroups($ruleGroups);

    /**
     * Get Rule Groups
     *
     * @return Collection Rule Groups
     */
    public function getRuleGroups();

    /**
     * Add Rule group
     *
     * @param RuleGroupInterface $ruleGroup Rule Group
     *
     * @return RuleInterface self Object
     */
    public function addRuleGroup(RuleGroupInterface $ruleGroup);

    /**
     * Removed Rule Group
     *
     * @param RuleGroupInterface $ruleGroup Rule Group
     *
     * @return RuleInterface self Object
     */
    public function removeRuleGroup(RuleGroupInterface $ruleGroup);
}
 