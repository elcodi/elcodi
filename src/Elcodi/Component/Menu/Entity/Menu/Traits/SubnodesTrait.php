<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
 * Trait SubnodesTrait.
 */
trait SubnodesTrait
{
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * Subnodes
     */
    protected $subnodes;

    /**
     * Add subnode.
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
     * Remove subnode.
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
     * Sets Subnodes.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $subnodes Subnodes
     *
     * @return $this Self object
     */
    public function setSubnodes(\Doctrine\Common\Collections\ArrayCollection $subnodes)
    {
        $this->subnodes = $subnodes;

        return $this;
    }

    /**
     * Get Subnodes sorted by priority.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection Subnodes
     */
    public function getSubnodes()
    {
        $sort = \Doctrine\Common\Collections\Criteria::create();
        $sort->orderBy([
            'priority' => \Doctrine\Common\Collections\Criteria::DESC,
        ]);

        return $this
            ->subnodes
            ->matching($sort);
    }

    /**
     * Get Subnodes sorted by priority and filtered by tag.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection Subnodes
     */
    public function getSubnodesByTag($tag)
    {
        return $this
            ->getSubnodes()
            ->filter(function (\Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface $menuNode) use ($tag) {

                return $menuNode->getTag() == $tag;
            });
    }

    /**
     * Find subnode given its name. You can decide if this search is deep or
     * not.
     *
     * This node is returned as soon as is found.
     *
     * @param string $subnodeName Subnode name
     * @param bool   $inDepth     In depth
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

        return null;
    }
}
