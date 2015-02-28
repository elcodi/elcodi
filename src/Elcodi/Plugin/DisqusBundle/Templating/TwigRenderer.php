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

namespace Elcodi\Plugin\DisqusBundle\Templating;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;

/**
 * Class TwigRenderer
 */
class TwigRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Set plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders disqus JS element
     *
     * @param EventInterface $event Event
     */
    public function renderJavascript(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin, [
            'disqus_identifier',
        ])
        ) {
            $this->appendTemplate(
                '@ElcodiDisqus/javascript.html.twig',
                $event,
                ['disqus_identifier' => $this->plugin->getConfiguration()['disqus_identifier']]
            );
        }
    }

    /**
     * Renders disqus block on blog post
     *
     * @param EventInterface $event Event
     */
    public function renderDisqusBlogPostBlock(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin, [
            'disqus_identifier',
            'disqus_enabled_blog_post',
        ])
        ) {
            $this->appendTemplate(
                '@ElcodiDisqus/block.html.twig',
                $event,
                ['disqus_identifier' => $this->plugin->getConfiguration()['disqus_identifier']]
            );
        }
    }

    /**
     * Renders disqus block on product page
     *
     * @param EventInterface $event Event
     */
    public function renderDisqusProductBlock(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin, [
            'disqus_identifier',
            'disqus_enabled_product',
        ])
        ) {
            $this->appendTemplate(
                '@ElcodiDisqus/block.html.twig',
                $event,
                ['disqus_identifier' => $this->plugin->getConfiguration()['disqus_identifier']]
            );
        }
    }
}
