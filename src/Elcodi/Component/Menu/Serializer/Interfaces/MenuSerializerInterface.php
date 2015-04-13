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

namespace Elcodi\Component\Menu\Serializer\Interfaces;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\SubnodesAwareInterface;

/**
 * Interface MenuSerializerInterface
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface MenuSerializerInterface
{
    /**
     * Serialize menu node
     *
     * @param NodeInterface $node Node
     *
     * @return mixed Serialized node
     */
    public function serialize(NodeInterface $node);

    /**
     * Given a node, serialize every child
     *
     * @param SubnodesAwareInterface $node Node
     *
     * @return array Serialized nodes
     */
    public function serializeSubnodes(SubnodesAwareInterface $node);
}
