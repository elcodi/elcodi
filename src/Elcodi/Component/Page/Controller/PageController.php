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

namespace Elcodi\Component\Page\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;
use Elcodi\Component\Page\Repository\PageRepository;

/**
 * Class PageController
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PageController
{
    /**
     * @var PageRepository
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
     *
     * Page renderer
     */
    protected $pageRenderer;

    /**
     * Constructor
     *
     * @param PageRepository        $repository   Page repository
     * @param RequestStack          $requestStack Request stack
     * @param PageRendererInterface $pageRenderer Content renderer
     */
    public function __construct(
        PageRepository $repository,
        RequestStack $requestStack,
        PageRendererInterface $pageRenderer = null
    ) {
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
    public function renderByPathAction($path = '')
    {
        $page = $this
            ->repository
            ->findOneByPath($path);

        return $this->createResponseFromPage($page);
    }

    /**
     * Renders a page given its id, language and path
     *
     * @param string $id Id
     *
     * @return Response
     *
     * @throws NotFoundHttpException Page not found
     */
    public function renderByIdAction($id)
    {
        $page = $this
            ->repository
            ->findOneById($id);

        return $this->createResponseFromPage($page);
    }

    /**
     * Render a page given the found instance
     *
     * @param PageInterface|null $page Found page
     *
     * @return Response Page rendered
     *
     * @throws NotFoundHttpException Page not found
     */
    protected function createResponseFromPage(PageInterface $page = null)
    {
        if (!($page instanceof PageInterface)) {
            throw new NotFoundHttpException('Page not found');
        }

        $request = $this
            ->requestStack
            ->getCurrentRequest();

        $response = $this->createResponseInstance($page);

        if (!$response->isNotModified($request)) {
            $response->setContent($this->renderPage($page));
            $response->headers->set('Content-Type', 'text/html');
        }

        return $response;
    }

    /**
     * Creates response instance
     *
     * @param PageInterface $page Page
     *
     * @return Response
     */
    protected function createResponseInstance(PageInterface $page)
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
     * @return string Page content
     */
    protected function renderPage(PageInterface $page)
    {
        if ($this->pageRenderer && $this->pageRenderer->supports($page)) {
            return $this
                ->pageRenderer
                ->render($page);
        }

        return $page->getContent();
    }
}
