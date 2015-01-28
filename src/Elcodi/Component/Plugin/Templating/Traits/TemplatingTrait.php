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

namespace Elcodi\Component\Plugin\Templating\Traits;

/**
 * Trait TemplatingTrait
 */
trait TemplatingTrait
{
    /**
     * Current Twig environment
     *
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Set templating
     *
     * @param \Twig_Environment $twig
     *
     * @return $this Self object
     */
    public function setTemplating(\Twig_Environment $twig)
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * Render a template and append to the current content
     *
     * @param string                                             $template
     * @param \Elcodi\Component\Plugin\Interfaces\EventInterface $event
     */
    protected function appendTemplate($template, \Elcodi\Component\Plugin\Interfaces\EventInterface $event)
    {
        $event->setContent(
            $event->getContent() .
            $this
                ->twig
                ->render(
                    $template,
                    $event->getContext()
                )
        );
    }
}
