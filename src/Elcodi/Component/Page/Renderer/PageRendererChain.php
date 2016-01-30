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

namespace Elcodi\Component\Page\Renderer;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;

/**
 * Class PageRendererChain.
 *
 * @author Berny Cantos <be@rny.cc>
 */
class PageRendererChain implements PageRendererInterface
{
    /**
     * @var PageRendererInterface[]
     *
     * Multiple page renderers to select
     */
    private $renderers;

    /**
     * Construct.
     *
     * @param PageRendererInterface[] $renderers Renderers
     */
    public function __construct(array $renderers = [])
    {
        $this->renderers = $renderers;
    }

    /**
     * Adds a new renderer.
     *
     * @param PageRendererInterface $renderer
     *
     * @return $this Self object
     */
    public function addRenderer(PageRendererInterface $renderer)
    {
        $this->renderers[] = $renderer;

        return $this;
    }

    /**
     * Render a page.
     *
     * @param PageInterface $page Page to render
     *
     * @return string Rendered content
     */
    public function render(PageInterface $page)
    {
        foreach ($this->renderers as $renderer) {
            if (!$renderer->supports($page)) {
                continue;
            }

            return $renderer->render($page);
        }

        return $page->getContent();
    }

    /**
     * Supports everything because falls back to `getContent`.
     *
     * @param PageInterface $page Page to check support
     *
     * @return bool
     */
    public function supports(PageInterface $page)
    {
        return true;
    }
}
