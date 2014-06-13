<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Class RuleGroupInterface
 */
interface RuleGroupInterface extends AbstractRuleInterface
{
    /**
     * Sets Rules
     *
     * @param Collection $rules Rules
     *
     * @return RuleGroupInterface Self object
     */
    public function setRules($rules);

    /**
     * Get Rules
     *
     * @return Collection Rules
     */
    public function getRules();

    /**
     * Add rule
     *
     * @param AbstractRuleInterface $rule Rule
     *
     * @return RuleGroupInterface self Object
     */
    public function addRule(AbstractRuleInterface $rule);

    /**
     * Remove rule
     *
     * @param AbstractRuleInterface $rule Rule
     *
     * @return RuleGroupInterface self Object
     */
    public function removeRule(AbstractRuleInterface $rule);
}
