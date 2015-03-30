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

namespace Elcodi\Plugin\FacebookBundle\Templating;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;

/**
 * Class JavascriptRenderer
 */
class JavascriptRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Set the plugin
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
     * Renders the javascript.
     *
     * @param EventInterface $event The event
     */
    public function renderJavascript(EventInterface $event)
    {
        if ($this->plugin->isEnabled()) {
            $this->appendTemplate(
                '@ElcodiFacebook/javascript.html.twig',
                $event
            );
        }
    }
}
