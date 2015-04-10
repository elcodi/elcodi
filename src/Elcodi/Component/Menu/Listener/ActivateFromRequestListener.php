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

namespace Elcodi\Component\Menu\Listener;

use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Menu\Event\MenuEvent;

/**
 * Class ActivateFromRequestListener
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ActivateFromRequestListener
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
     * Mark menu entries as active if matches the current route.
     * Also mark entries as expanded if any subnode is the current route.
     *
     * @param MenuEvent $event
     */
    public function onMenuPostLoad(MenuEvent $event)
    {
        $masterRequest = $this
            ->requestStack
            ->getMasterRequest();

        if (!$masterRequest) {
            return;
        }

        $currentRoute = $masterRequest->get('_route');

        $event->addFilter(function (array $item) use ($currentRoute) {

            if (in_array($currentRoute, $item['activeUrls'])) {
                $item['active'] = true;
            }

            return $item;
        });

        $event->addFilter(function (array $item) use ($currentRoute) {

            $item['expanded'] = false;
            foreach ($item['subnodes'] as $subnode) {
                if (in_array($currentRoute, $subnode['activeUrls'])) {
                    $item['expanded'] = true;
                }
            }

            return $item;
        });
    }
}
