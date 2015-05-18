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

namespace Elcodi\Component\Menu\Entity\Menu\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface SubnodesAwareInterface
 */
interface SubnodesAwareInterface
{
    /**
     * Add subnode
     *
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function addSubnode(NodeInterface $node);

    /**
     * Remove subnode
     *
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function removeSubnode(NodeInterface $node);

    /**
     * Sets Subnodes
     *
     * @param Collection $subnodes Subnodes
     *
     * @return $this Self object
     */
    public function setSubnodes(Collection $subnodes);

    /**
     * Get Subnodes
     *
     * @return Collection Subnodes
     */
    public function getSubnodes();

    /**
     * Find subnode given its name. You can decide if this search is deep or
     * not.
     *
     * This node is returned as soon as is found.
     *
     * @param string  $subnodeName Subnode name
     * @param boolean $inDepth     In depth
     *
     * @return NodeInterface|null Node
     */
    public function findSubnodeByName($subnodeName, $inDepth = true);

    /**
     * Sets Sort
     *
     * @param string $sort Sort
     *
     * @return $this Self object
     */
    public function setSort($sort);

    /**
     * Get Sort
     *
     * @return string Sort
     */
    public function getSort();
}
