<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\RuleBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Class RulesAwareInterface
 */
interface RulesAwareInterface
{
    /**
     * Add Rule
     *
     * @param AbstractRuleInterface $rule Rule to add
     *
     * @return Object self Object
     */
    public function addRule(AbstractRuleInterface $rule);

    /**
     * Remove rules
     *
     * @param AbstractRuleInterface $rule Rule to remove
     *
     * @return Object self Object
     */
    public function removeRule(AbstractRuleInterface $rule);

    /**
     * Set rules
     *
     * @param Collection $rules Rule set to be added
     *
     * @return Object self Object
     */
    public function setRules(Collection $rules);

    /**
     * Get rules
     *
     * @return Collection Rule set
     */
    public function getRules();
}
