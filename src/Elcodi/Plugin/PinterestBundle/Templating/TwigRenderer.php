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

namespace Elcodi\Plugin\PinterestBundle\Templating;

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
     * Renders import/export buttons
     *
     * @param EventInterface $event Event
     */
    public function renderJavascript(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin, [
            'asynchronous',
        ])
        ) {
            $this->appendTemplate('@ElcodiPinterest/javascript.html.twig', $event);
        }
    }

    /**
     * Renders asynchronous javascript
     *
     * @param EventInterface $event Event
     */
    public function renderAsynchronousJavascript(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin, [
            'asynchronous',
        ])
        ) {
            $this->appendTemplate('@ElcodiPinterest/javascript_asynchronous.html.twig', $event);
        }
    }

    /**
     * Renders import/export buttons
     *
     * @param EventInterface $event Event
     */
    public function renderPin(EventInterface $event)
    {
        if ($this->pluginCanBeUsed($this->plugin)
        ) {
            $this->appendTemplate('@ElcodiPinterest/product_pin.html.twig', $event);
        }
    }
}
