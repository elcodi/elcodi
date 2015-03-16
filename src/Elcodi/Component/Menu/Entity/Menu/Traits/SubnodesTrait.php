<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Menu\Entity\Menu\Traits;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;

/**
 * Trait SubnodesTrait
 */
trait SubnodesTrait
{
    /**
     * @var Collection
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
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function addSubnode(NodeInterface $node)
    {
        if ($node !== $this) {
            $this->subnodes->add($node);
        }

        return $this;
    }

    /**
     * Remove subnode
     *
     * @param NodeInterface $node Node
     *
     * @return $this Self object
     */
    public function removeSubnode(NodeInterface $node)
    {
        $this->subnodes->removeElement($node);

        return $this;
    }

    /**
     * Sets Subnodes
     *
     * @param Collection $subnodes Subnodes
     *
     * @return $this Self object
     */
    public function setSubnodes(Collection $subnodes)
    {
        $this->subnodes = $subnodes;

        return $this;
    }

    /**
     * Get Subnodes
     *
     * @return Collection Subnodes
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
