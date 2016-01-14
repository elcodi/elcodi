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

namespace Elcodi\Component\Page\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Repository\PageRepository;
use Elcodi\Component\Page\Transformer\PageResponseTransformer;

/**
 * Class PageController.
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
    private $pageRepository;

    /**
     * @var PageResponseTransformer
     *
     * PageResponse Transformer
     */
    private $pageResponseTransformer;

    /**
     * Constructor.
     *
     * @param PageRepository          $pageRepository          Page repository
     * @param PageResponseTransformer $pageResponseTransformer PageResponse Transformer
     */
    public function __construct(
        PageRepository $pageRepository,
        PageResponseTransformer $pageResponseTransformer
    ) {
        $this->pageRepository = $pageRepository;
        $this->pageResponseTransformer = $pageResponseTransformer;
    }

    /**
     * Renders a page given its id and path.
     *
     * @param string $id   Page id
     * @param string $path Page path
     *
     * @return Response Generated response
     *
     * @throws NotFoundHttpException Page not found
     */
    public function renderByIdAction($id, $path = '')
    {
        /**
         * @var PageInterface $page
         */
        $page = $this
            ->pageRepository
            ->findOneById($id);

        return $this
            ->pageResponseTransformer
            ->createResponseFromPage(
                $page,
                $path
            );
    }

    /**
     * Renders a page given its path.
     *
     * @param string $path Page path
     *
     * @return Response Generated response
     *
     * @throws NotFoundHttpException Page not found
     */
    public function renderByPathAction($path = '')
    {
        /**
         * @var PageInterface $page
         */
        $page = $this
            ->pageRepository
            ->findOneByPath($path);

        return $this
            ->pageResponseTransformer
            ->createResponseFromPage(
                $page,
                $path
            );
    }
}
