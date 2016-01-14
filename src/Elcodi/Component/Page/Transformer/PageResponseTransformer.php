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

namespace Elcodi\Component\Page\Transformer;

use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\Page\ElcodiPageTypes;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;

/**
 * Class PageResponseTransformer.
 */
class PageResponseTransformer
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    private $requestStack;

    /**
     * @var UrlGeneratorInterface
     *
     * Url Generator
     */
    private $urlGenerator;

    /**
     * @var PageRendererInterface
     *
     * Page renderer
     */
    private $pageRenderer;

    /**
     * @var string
     *
     * Page Render route
     */
    private $pageRenderRoute;

    /**
     * Constructor.
     *
     * @param RequestStack          $requestStack    Request stack
     * @param UrlGeneratorInterface $urlGenerator    Url generator
     * @param PageRendererInterface $pageRenderer    Content renderer
     * @param string                $pageRenderRoute Page render route
     */
    public function __construct(
        RequestStack $requestStack,
        UrlGeneratorInterface $urlGenerator,
        PageRendererInterface $pageRenderer,
        $pageRenderRoute
    ) {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
        $this->pageRenderer = $pageRenderer;
        $this->pageRenderRoute = $pageRenderRoute;
    }

    /**
     * Render a page given the found instance.
     *
     * @param PageInterface|null $page Found page
     * @param string             $path Page route path
     *
     * @return Response Page rendered
     *
     * @throws RuntimeException      Request object not found
     * @throws NotFoundHttpException Page not found or not valid
     */
    public function createResponseFromPage(
        PageInterface $page = null,
        $path = ''
    ) {
        if (
            !($page instanceof PageInterface) ||
            $page->getType() !== ElcodiPageTypes::TYPE_REGULAR
        ) {
            throw new NotFoundHttpException('Page not found');
        }

        $request = $this
            ->requestStack
            ->getCurrentRequest();

        /**
         * Request not found because this controller is not running under
         * Request scope.
         */
        if (!($request instanceof Request)) {
            throw new RuntimeException('Request object not found');
        }

        /**
         * We must check that the product slug is right. Otherwise we must
         * return a Redirection 301 to the right url.
         */
        if (
            $page->getPath() &&
            $path !== $page->getPath()
        ) {
            return new RedirectResponse(
                $this
                    ->urlGenerator
                    ->generate($this->pageRenderRoute, [
                        'id' => $page->getId(),
                        'path' => $page->getPath(),
                    ]),
                301
            );
        }

        $response = $this->createResponseInstance($page);

        if (!$response->isNotModified($request)) {
            $response->setContent($this->renderPage($page));
            $response->headers->set('Content-Type', 'text/html');
        }

        return $response;
    }

    /**
     * Creates response instance.
     *
     * @param PageInterface $page Page
     *
     * @return Response
     */
    private function createResponseInstance(PageInterface $page)
    {
        $response = new Response();

        $response
            ->setLastModified($page->getUpdatedAt())
            ->setPublic();

        return $response;
    }

    /**
     * Renders page content.
     *
     * @param PageInterface $page
     *
     * @return string Page content
     */
    private function renderPage(PageInterface $page)
    {
        if ($this->pageRenderer && $this->pageRenderer->supports($page)) {
            return $this
                ->pageRenderer
                ->render($page);
        }

        return $page->getContent();
    }
}
