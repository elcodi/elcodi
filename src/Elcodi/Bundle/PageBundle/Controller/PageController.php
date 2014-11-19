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

namespace Elcodi\Bundle\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Page\Services\Interfaces\RouterInterface;

/**
 * Class PageController
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PageController
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Renders a page
     *
     * @param Request $request
     *
     * @return Response
     */
    public function renderAction(Request $request)
    {
        $response = $this->router->handleRequest($request);

        if (null === $response) {
            throw new NotFoundHttpException('Page not found');
        }

        return $response;
    }
}
