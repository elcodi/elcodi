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

namespace Elcodi\Component\Plugin\Templating\Traits;

/**
 * Trait TemplatingTrait.
 */
trait TemplatingTrait
{
    /**
     * Current Twig environment.
     *
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Set templating.
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
     * Render a template and append to the current content.
     *
     * @param string                                                             $template
     * @param \Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface $event
     * @param array                                                              $extraContextParams
     */
    protected function appendTemplate(
        $template,
        \Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface $event,
        \Elcodi\Component\Plugin\Entity\Plugin $plugin,
        array $extraContextParams = []
    ) {
        $event->setContent(
            $event->getContent() .
            $this
                ->twig
                ->render(
                    $template,
                    array_merge(
                        $event->getContext(),
                        ['plugin' => $plugin],
                        $extraContextParams
                    )
                )
        );
    }
}
