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
 * Class RuleGroup
 */
class RuleGroup extends AbstractEntity implements RuleGroupInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Rule Group name
     */
    protected $name;

    /**
     * @var string
     *
     * Rule Group code
     */
    protected $code;

    /**
     * @var Collection
     *
     * Rules
     */
    protected $rules;

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return RuleGroup Self object
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
     * @return RuleGroup Self object
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
     * @param RuleInterface $rule Rule
     *
     * @return RuleGroup self Object
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules->add($rule);

        return $this;
    }

    /**
     * Remove rule
     *
     * @param RuleInterface $rule Rule
     *
     * @return RuleGroup self Object
     */
    public function removeRule(RuleInterface $rule)
    {
        $this->rules->removeElement($rule);

        return $this;
    }
}
 