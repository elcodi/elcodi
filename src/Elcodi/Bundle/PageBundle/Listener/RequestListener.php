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
 */

namespace Elcodi\Bundle\PageBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Elcodi\Component\Page\Services\Interfaces\RouterInterface;

class RequestListener
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function handleRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $this->router->handleRequest($request);

        if ($response instanceof Response) {

            $event->setResponse($response);
            $event->stopPropagation();
        }
    }
}
