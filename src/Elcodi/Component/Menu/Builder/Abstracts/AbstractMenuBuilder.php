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

namespace Elcodi\Component\Menu\Builder\Abstracts;

use Elcodi\Component\Menu\Factory\NodeFactory;

/**
 * Class AbstractMenuBuilder.
 */
class AbstractMenuBuilder
{
    /**
     * @var NodeFactory
     *
     * Menu node factory
     */
    protected $menuNodeFactory;

    /**
     * Construct.
     *
     * @param NodeFactory $menuNodeFactory Menu node factory
     */
    public function __construct(NodeFactory $menuNodeFactory)
    {
        $this->menuNodeFactory = $menuNodeFactory;
    }
}
