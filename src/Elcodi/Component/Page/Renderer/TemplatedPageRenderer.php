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

namespace Elcodi\Component\Page\Renderer;

use RuntimeException;
use Symfony\Component\Templating\EngineInterface;

use Elcodi\Bundle\BambooBundle\Entity\Page as BambooPage;
use Elcodi\Component\Page\Entity\Interfaces\PageInterface;
use Elcodi\Component\Page\Renderer\Interfaces\PageRendererInterface;

/**
 * Class TemplatedPageRenderer
 *
 * Add layout rendering
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TemplatedPageRenderer implements PageRendererInterface
{
    /**
     * @var EngineInterface
     *
     * Render engine
     */
    protected $engine;

    /**
     * @var string
     *
     * Path of the template to render
     */
    protected $templatePath;

    /**
     * @var array
     *
     * Bundles to search
     */
    protected $bundles;

    /**
     * Construct
     *
     * @param EngineInterface $engine  Render engine
     * @param string          $path    Relative path to the template
     * @param array           $bundles Array of bundles to search
     */
    public function __construct(
        EngineInterface $engine,
        $path,
        array $bundles
    ) {
        $this->engine = $engine;
        $this->templatePath = $path;
        $this->bundles = $bundles;
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
        $templateName = $this->locateTemplate();

        return $this
            ->engine
            ->render(
                $templateName, array(
                    'page' => $page,
                )
            );
    }

    /**
     * Search for the template in every specified bundle
     *
     * @return string
     */
    protected function locateTemplate()
    {
        foreach ($this->bundles as $bundleName) {
            $templateName = "{$bundleName}:{$this->templatePath}";

            if ($this->engine->exists($templateName)) {
                return $templateName;
            }
        }

        throw new RuntimeException(sprintf(
            'Template "%s" not found',
            $this->templatePath
        ));
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
