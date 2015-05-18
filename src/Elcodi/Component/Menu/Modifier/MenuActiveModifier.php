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

namespace Elcodi\Component\Menu\Modifier;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Modifier\Interfaces\MenuModifierInterface;

/**
 * Class MenuActiveModifier
 */
class MenuActiveModifier implements MenuModifierInterface
{
    /**
     * @var RequestStack
     *
     * Current request stack
     */
    protected $requestStack;

    /**
     * Constructor
     *
     * @param RequestStack $requestStack request stack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Modifier the menu node
     *
     * @param NodeInterface $menuNode Menu node
     */
    public function modify(NodeInterface $menuNode)
    {
        $masterRequest = $this
            ->requestStack
            ->getMasterRequest();

        if ($masterRequest instanceof Request) {
            $currentRoute = $masterRequest->get('_route');

            if (in_array($currentRoute, $menuNode->getActiveUrls())) {
                $menuNode->setActive(true);
            }
        }
    }
}
