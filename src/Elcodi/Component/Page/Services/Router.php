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

namespace Elcodi\Component\Page\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Repository\Interfaces\PageRepositoryInterface;
use Elcodi\Component\Page\Services\Interfaces\RendererInterface;
use Elcodi\Component\Page\Services\Interfaces\RouterInterface;

/**
 * Class Router
 *
 * @author Jonas HAOUZI <haouzijonas@gmail.com>
 * @author Àlex Corretgé <alex@corretge.cat>
 * @author Berny Cantos <be@rny.cc>
 */
class Router implements RouterInterface
{
    /**
     * @var PageRepositoryInterface
     */
    protected $repository;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @param PageRepositoryInterface $repository
     * @param RendererInterface $renderer
     */
    public function __construct(PageRepositoryInterface $repository, RendererInterface $renderer)
    {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function handleRequest(Request $request)
    {
        $routable = $this->repository->findOneByPath($request->getUri());

        if ($routable instanceof PageInterface) {

            return $this->render($routable);
        }
    }

    /**
     * @param PageInterface $routable
     * @return Response
     */
    public function render(PageInterface $routable)
    {
        $content = $this->renderer->render($routable);

        return new Response($content);
    }
}
