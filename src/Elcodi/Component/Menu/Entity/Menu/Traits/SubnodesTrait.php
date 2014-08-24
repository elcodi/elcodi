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

namespace Elcodi\Component\Menu\Entity\Menu\Traits;

/**
 * Trait SubnodesTrait
 */
trait SubnodesTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * Subnodes
     */
    protected $subnodes;

    /**
     * @var string
     *
     * Sort
     */
    protected $sort;

    /**
     * Add subnode
     *
     * @param \Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $node Node
     *
     * @return Object self Object
     */
    public function addSubnode(\Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $node)
    {
        if ($node !== $this) {
            $this->subnodes->add($node);
        }

        return $this;
    }

    /**
     * Remove subnode
     *
     * @param \Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $node Node
     *
     * @return Object self Object
     */
    public function removeSubnode(\Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $node)
    {
        $this->subnodes->removeElement($node);

        return $this;
    }

    /**
     * Sets Subnodes
     *
     * @param \Doctrine\Common\Collections\Collection $subnodes Subnodes
     *
     * @return Object Self object
     */
    public function setSubnodes(\Doctrine\Common\Collections\Collection $subnodes)
    {
        $this->subnodes = $subnodes;

        return $this;
    }

    /**
     * Get Subnodes
     *
     * @return \Doctrine\Common\Collections\Collection Subnodes
     */
    public function getSubnodes()
    {
        return $this->subnodes;
    }

    /**
     * Sets Sort
     *
     * @param string $sort Sort
     *
     * @return Object Self object
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get Sort
     *
     * @return string Sort
     */
    public function getSort()
    {
        return $this->sort;
    }
}
