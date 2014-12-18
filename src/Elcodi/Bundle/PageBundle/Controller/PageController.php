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

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
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
     */
    protected $repository;

    /**
     * @param PageRepositoryInterface $repository
     */
    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Renders a page
     *
     * @param Request $request
     * @param string  $path
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function renderAction(Request $request, $path = '')
    {
        $page = $this->repository->findOneByPath($path);
        if (null === $page) {
            throw new NotFoundHttpException('Page not found');
        }

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
            ->setPublic()
        ;

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
        return $page->getContent();
    }
}
