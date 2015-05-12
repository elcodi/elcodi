<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
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
     * Find subnode given its name. You can decide if this search is deep or
     * not.
     *
     * This node is returned as soon as is found.
     *
     * @param string  $subnodeName Subnode name
     * @param boolean $inDepth     In depth
     *
     * @return \Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface|null Node
     */
    public function findSubnodeByName($subnodeName, $inDepth = true)
    {
        $subnodes = $this->getSubnodes();

        /**
         * @var \Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $subnode
         */
        foreach ($subnodes as $subnode) {
            if ($subnodeName == $subnode->getName()) {
                return $subnode;
            }

            if ($inDepth) {
                $subnode = $subnode->findSubnodeByName($subnodeName, $inDepth);

                if ($subnode instanceof \Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface) {
                    return $subnode;
                }
            }
        }

        return;
    }

    /**
     * Sets Sort
     *
     * @param string $sort Sort
     *
     * @return $this Self object
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
