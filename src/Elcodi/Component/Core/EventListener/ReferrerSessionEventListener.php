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

namespace Elcodi\Component\Core\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class ReferrerSessionEventListener.
 */
class ReferrerSessionEventListener
{
    /**
     * Update referrer from session.
     *
     * @param GetResponseEvent $event Event
     */
    public function updateSessionReferrer(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $server = $event
            ->getRequest()
            ->server;

        $referrer = parse_url($server->get('HTTP_REFERER', false), PHP_URL_HOST);
        $host = parse_url($server->get('HTTP_HOST'), PHP_URL_HOST);

        if (
            ($referrer != $host) &&
            ($referrer !== false)
        ) {
            $event
                ->getRequest()
                ->getSession()
                ->set('referrer', $referrer);
        }
    }
}
