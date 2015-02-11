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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\BambooBundle\Renderer;

use Symfony\Component\Templating\EngineInterface;
use Elcodi\Bundle\BambooBundle\Entity\Page as BambooPage;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;

/**
 * Class TemplateRenderer
 *
 * Add layout rendering
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TemplateRenderer implements PageRendererInterface
{
    /**
     * @var EngineInterface
     *
     * Render engine
     */
    protected $engine;

    /**
     * Construct
     *
     * @param EngineInterface $engine Render engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Render a page
     *
     * @param PageInterface $page Page to render
     *
     * @return string Rendered content
     */
    public function render(PageInterface $page)
    {
        return $this
            ->engine
            ->render(
                'ElcodiBambooBundle:Page:layout.html.twig',
                array(
                    'page' => $page,
                )
            );
    }

    /**
     * Check for render support of a page
     *
     * @param PageInterface $page Page to check support
     *
     * @return bool
     */
    public function supports(PageInterface $page)
    {
        return $page instanceof BambooPage;
    }
}
