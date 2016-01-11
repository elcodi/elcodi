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

namespace Elcodi\Component\Menu\Entity\Menu\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface SubnodesAwareInterface.
 */
interface SubnodesAwareInterface
{
    /**
     * Add subnode.
     *
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function addSubnode(NodeInterface $node);

    /**
     * Remove subnode.
     *
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function removeSubnode(NodeInterface $node);

    /**
     * Sets Subnodes.
     *
     * @param ArrayCollection $subnodes Subnodes
     *
     * @return $this Self object
     */
    public function setSubnodes(ArrayCollection $subnodes);

    /**
     * Get Subnodes.
     *
     * @return ArrayCollection Subnodes
     */
    public function getSubnodes();

    /**
     * Get Subnodes sorted by priority and filtered by tag.
     *
     * @return ArrayCollection Subnodes
     */
    public function getSubnodesByTag($tag);

    /**
     * Find subnode given its name. You can decide if this search is deep or
     * not.
     *
     * This node is returned as soon as is found.
     *
     * @param string $subnodeName Subnode name
     * @param bool   $inDepth     In depth
     *
     * @return NodeInterface|null Node
     */
    public function findSubnodeByName($subnodeName, $inDepth = true);
}
