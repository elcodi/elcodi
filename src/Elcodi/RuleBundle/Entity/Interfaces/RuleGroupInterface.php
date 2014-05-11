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
 * Class RuleGroupInterface
 */
interface RuleGroupInterface extends EnabledInterface
{
    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return RuleGroupInterface Self object
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
     * @return RuleGroupInterface Self object
     */
    public function setCode($code);

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode();

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
     * @param RuleInterface $rule Rule
     *
     * @return RuleGroupInterface self Object
     */
    public function addRule(RuleInterface $rule);

    /**
     * Remove rule
     *
     * @param RuleInterface $rule Rule
     *
     * @return RuleGroupInterface self Object
     */
    public function removeRule(RuleInterface $rule);
}
 