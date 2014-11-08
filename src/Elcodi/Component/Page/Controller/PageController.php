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

use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Repository\PageRepository;

/**
 * Class PageController
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
     * @var ParserInterface
     *
     * Page content parser
     */
    protected $parser;

    /**
     * Construct method
     *
     * @param PageRepository $pageRepository Page Repository
     * @param ParserInterface $parser Parser
     */
    public function __construct(
        PageRepository $pageRepository,
        ParserInterface $parser
    )
    {
        $this->pageRepository = $pageRepository;
        $this->parser = $parser;
    }

    /**
     * Renders and Parses a page
     *
     * @param string $pageCode Page identifier
     *
     * @return string Page render
     */
    public function renderAction($pageCode)
    {
        $page = $this
            ->pageRepository
            ->findOneBy([
                'code' => $pageCode
            ]);

        if (!($page instanceof PageInterface)) {

            return new Response('Page not found', 404);
        }

        return $this
            ->parser
            ->parse($page);
    }
}
