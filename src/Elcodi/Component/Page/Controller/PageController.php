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

namespace Elcodi\Component\Page\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;
use Elcodi\Component\Page\Repository\Interfaces\PageRepositoryInterface;

/**
 * Class PageController
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PageController
{
    /**
     * @var PageRepositoryInterface
     *
     * Page repository
     */
    protected $repository;

    /**
     * @var RequestStack
     *
     * Request stack
     */
    protected $requestStack;

    /**
     * @var PageRendererInterface
     */
    protected $pageRenderer;

    /**
     * Constructor
     *
     * @param PageRepositoryInterface $repository   Page repository
     * @param RequestStack            $requestStack Request stack
     * @param PageRendererInterface   $pageRenderer Content renderer
     */
    public function __construct(
        PageRepositoryInterface $repository,
        RequestStack $requestStack,
        PageRendererInterface $pageRenderer = null
    )
    {
        $this->repository = $repository;
        $this->requestStack = $requestStack;
        $this->pageRenderer = $pageRenderer;
    }

    /**
     * Renders a page
     *
     * @param string $path Path
     *
     * @return Response
     *
     * @throws NotFoundHttpException Page not found
     */
    public function renderAction($path = '')
    {
        $page = $this
            ->repository
            ->findOneByPath($path);

        if (!($page instanceof PageInterface)) {

            throw new NotFoundHttpException('Page not found');
        }

        $request = $this
            ->requestStack
            ->getCurrentRequest();

        $response = $this->createResponse($page);

        if (!$response->isNotModified($request)) {

            $response->setContent($this->renderPage($page));
            $response->headers->set('Content-Type', 'text/html');
        }

        return $response;
    }

    /**
     * @param PageInterface $page
     *
     * @return Response
     */
    protected function createResponse(PageInterface $page)
    {
        $response = new Response();

        $response
            ->setLastModified($page->getUpdatedAt())
            ->setPublic();

        return $response;
    }

    /**
     * Renders page content
     *
     * @param PageInterface $page
     *
     * @return string
     */
    protected function renderPage(PageInterface $page)
    {
        if ($this->pageRenderer && $this->pageRenderer->supports($page)) {
            return $this->pageRenderer->render($page);
        }

        return $page->getContent();
    }
}
